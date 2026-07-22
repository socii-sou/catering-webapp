<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PembayaranController extends Controller
{
    public function __construct(protected MidtransService $midtransService)
    {
    }

    #[OA\Post(
        path: '/api/pesanan/{pesanan}/bayar',
        summary: 'Generate Snap Token untuk pembayaran DP atau Pelunasan',
        description: 'Nominal DIHITUNG DI SERVER (persentase DP dari config), bukan dari input pelanggan, supaya tidak bisa dimanipulasi.',
        tags: ['Pembayaran'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'pesanan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['jenis_pembayaran'],
                properties: [
                    new OA\Property(property: 'jenis_pembayaran', type: 'string', enum: ['dp', 'pelunasan'], example: 'dp'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'snap_token siap dipakai di frontend'),
            new OA\Response(response: 403, description: 'Bukan pemilik pesanan ini'),
            new OA\Response(response: 422, description: 'Pesanan sudah lunas, atau DP sudah pernah diminta sebelumnya'),
        ]
    )]
    public function createSnapToken(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'jenis_pembayaran' => ['required', 'in:dp,pelunasan'],
        ]);

        $sisaTagihan = $pesanan->sisaTagihan();

        if ($sisaTagihan <= 0) {
            return response()->json(['message' => 'Pesanan ini sudah lunas.'], 422);
        }

        if ($data['jenis_pembayaran'] === 'dp') {
            // DP cuma boleh diminta sekali, di awal sebelum ada pembayaran apapun.
            if ($pesanan->totalDibayar() > 0) {
                return response()->json(['message' => 'DP hanya bisa diminta sebelum ada pembayaran lain.'], 422);
            }

            $persenDp = (float) config('services.midtrans.dp_percentage', 50);
            $totalKeseluruhan = (float) $pesanan->total_harga + (float) $pesanan->biaya_pengiriman;
            $jumlahBayar = round($totalKeseluruhan * ($persenDp / 100));
        } else {
            // Pelunasan = sisa tagihan apa adanya (baik itu 100% kalau belum pernah bayar,
            // atau 50% sisanya kalau DP sudah dibayar duluan).
            $jumlahBayar = $sisaTagihan;
        }

        $pembayaran = $this->midtransService->createSnapToken($pesanan, $jumlahBayar, $data['jenis_pembayaran']);

        return response()->json([
            'pembayaran_id' => $pembayaran->id,
            'jenis_pembayaran' => $pembayaran->jenis_pembayaran,
            'jumlah_bayar' => (float) $pembayaran->jml_bayar,
            'snap_token' => $pembayaran->snap_token,
        ]);
    }

    #[OA\Post(
        path: '/api/webhook/midtrans',
        summary: 'Webhook notifikasi status pembayaran dari Midtrans',
        description: 'Dipanggil otomatis oleh server Midtrans, bukan oleh user. Diverifikasi lewat signature_key.',
        tags: ['Pembayaran'],
        responses: [
            new OA\Response(response: 200, description: 'Status pembayaran berhasil diupdate'),
            new OA\Response(response: 403, description: 'Signature tidak valid, kemungkinan request palsu'),
        ]
    )]
    public function webhook(Request $request)
    {
        if (! $this->midtransService->verifySignature($request->all())) {
            return response()->json(['message' => 'Invalid signature.'], 403);
        }

        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        $pembayaran = Pembayaran::where('transaction_id', $orderId)->firstOrFail();

        $statusBayar = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'lunas',
            $transactionStatus === 'settlement' => 'lunas',
            in_array($transactionStatus, ['deny', 'cancel', 'expire']) => 'gagal',
            $transactionStatus === 'pending' => 'pending',
            default => $pembayaran->status_bayar,
        };

        $pembayaran->update(['status_bayar' => $statusBayar]);

        if ($statusBayar === 'lunas' && $pembayaran->pesanan) {
            $pesanan = $pembayaran->pesanan;
            if (in_array($pesanan->status_pesanan, ['menunggu_validasi', 'pending'])) {
                $pesanan->update(['status_pesanan' => 'dikonfirmasi']);
            }
        }

        return response()->json(['message' => 'OK']);
    }
}