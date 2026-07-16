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
        summary: 'Generate Snap Token untuk munculkan popup pembayaran Midtrans',
        tags: ['Pembayaran'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'pesanan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['jumlah_bayar'],
                properties: [
                    new OA\Property(property: 'jumlah_bayar', type: 'number', format: 'float', example: 2500000),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'snap_token siap dipakai di frontend'),
            new OA\Response(response: 403, description: 'Bukan pemilik pesanan ini'),
        ]
    )]
    public function createSnapToken(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:1'],
        ]);

        $pembayaran = $this->midtransService->createSnapToken($pesanan, $data['jumlah_bayar']);

        return response()->json([
            'pembayaran_id' => $pembayaran->id,
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

        return response()->json(['message' => 'OK']);
    }
}