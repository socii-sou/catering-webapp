<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PesananController extends Controller
{
    #[OA\Get(
        path: '/api/penjual/pesanan',
        summary: 'Daftar semua pesanan (bisa difilter status)',
        tags: ['Penjual - Pesanan'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(
                name: 'status',
                in: 'query',
                required: false,
                description: 'Filter berdasarkan status_pesanan',
                schema: new OA\Schema(type: 'string', enum: ['menunggu_validasi', 'disetujui', 'ditolak', 'batal', 'selesai'])
            ),
        ],
        responses: [new OA\Response(response: 200, description: 'Daftar pesanan (paginated)')]
    )]
    public function index(Request $request)
    {
        $pesanans = Pesanan::with(['user', 'gubukan', 'pesananPaket.paket'])
            ->when($request->status, fn ($q, $status) => $q->where('status_pesanan', $status))
            ->latest('tgl_acara')
            ->paginate(15);

        return PesananResource::collection($pesanans);
    }

    #[OA\Patch(
        path: '/api/penjual/pesanan/{pesanan}/validasi',
        summary: 'Setujui atau tolak pesanan yang masuk',
        tags: ['Penjual - Pesanan'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'pesanan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status_pesanan'],
                properties: [
                    new OA\Property(property: 'status_pesanan', type: 'string', enum: ['disetujui', 'ditolak']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status berhasil diupdate'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function validasi(Request $request, Pesanan $pesanan)
    {
        $this->authorize('updateStatus', $pesanan);

        $request->validate([
            'status_pesanan' => ['required', 'string', 'in:menunggu_validasi,disetujui,dikonfirmasi,ditolak,batal,selesai'],
        ]);

        $pesanan->update(['status_pesanan' => $request->status_pesanan]);

        return new PesananResource($pesanan->fresh());
    }

    #[OA\Patch(
        path: '/api/penjual/pesanan/{pesanan}/produksi',
        summary: 'Update status dapur/produksi pesanan',
        tags: ['Penjual - Pesanan'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'pesanan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['status_produksi'],
                properties: [
                    new OA\Property(property: 'status_produksi', type: 'string', enum: ['belum_diproses', 'diproses', 'selesai']),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Status berhasil diupdate'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function updateProduksi(Request $request, Pesanan $pesanan)
    {
        $this->authorize('updateStatus', $pesanan);

        $request->validate([
            'status_produksi' => ['required', 'in:belum_diproses,diproses,selesai'],
        ]);

        $pesanan->update(['status_produksi' => $request->status_produksi]);

        return new PesananResource($pesanan->fresh());
    }

    public function updatePengiriman(Request $request, Pesanan $pesanan)
    {
        $this->authorize('updateStatus', $pesanan);

        $request->validate([
            'status_pengiriman' => ['required', 'in:belum_dikirim,dikirim,sampai'],
        ]);

        $pengiriman = $pesanan->pengiriman()->firstOrCreate(
            ['pesanan_id' => $pesanan->id],
            ['alamat_tujuan' => $pesanan->alamat_pengiriman]
        );

        $pengiriman->update([
            'status_pengiriman' => $request->status_pengiriman,
            'waktu_berangkat' => $request->status_pengiriman === 'dikirim' ? now() : $pengiriman->waktu_berangkat,
            'waktu_tiba' => $request->status_pengiriman === 'sampai' ? now() : $pengiriman->waktu_tiba,
        ]);

        if ($request->status_pengiriman === 'sampai') {
            $pesanan->update(['status_pesanan' => 'selesai']);
        }

        return new PesananResource($pesanan->fresh());
    }

    public function updatePembayaran(Request $request, Pesanan $pesanan)
    {
        $this->authorize('updateStatus', $pesanan);

        $request->validate([
            'status_bayar' => ['required', 'in:dikonfirmasi,lunas,menunggu_dp'],
        ]);

        $statusBayar = $request->status_bayar;

        if ($statusBayar === 'dikonfirmasi') {
            $pesanan->pembayarans()->firstOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'tgl_bayar' => now(),
                    'jml_bayar' => $pesanan->total_harga * 0.5,
                    'metode_bayar' => 'bank_transfer',
                    'status_bayar' => 'diverifikasi'
                ]
            )->update(['status_bayar' => 'diverifikasi']);

            $pesanan->update(['status_pesanan' => 'disetujui']);
        } elseif ($statusBayar === 'lunas') {
            $pembayaran = $pesanan->pembayarans()->firstOrCreate(
                ['pesanan_id' => $pesanan->id],
                [
                    'tgl_bayar' => now(),
                    'jml_bayar' => $pesanan->total_harga,
                    'metode_bayar' => 'bank_transfer',
                    'status_bayar' => 'lunas'
                ]
            );
            $pembayaran->update([
                'jml_bayar' => $pesanan->total_harga,
                'status_bayar' => 'lunas'
            ]);
            $pesanan->update(['status_pesanan' => 'disetujui']);
        } else {
            $pesanan->pembayarans()->update(['status_bayar' => 'menunggu_verifikasi']);
            $pesanan->update(['status_pesanan' => 'menunggu_validasi']);
        }

        return new PesananResource($pesanan->fresh());
    }
}