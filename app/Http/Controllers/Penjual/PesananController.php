<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * GET /penjual/pesanan?status=menunggu_validasi
     * Daftar semua pesanan, bisa difilter berdasarkan status_pesanan.
     */
    public function index(Request $request)
    {
        $pesanans = Pesanan::with(['user', 'gubukan', 'pesananPaket.paket'])
            ->when($request->status, fn ($q, $status) => $q->where('status_pesanan', $status))
            ->latest('tgl_acara')
            ->paginate(15);

        return response()->json($pesanans);
    }

    /**
     * PATCH /penjual/pesanan/{pesanan}/validasi
     * Penjual menyetujui atau menolak pesanan yang masuk.
     */
    public function validasi(Request $request, Pesanan $pesanan)
    {
        $this->authorize('updateStatus', $pesanan);

        $request->validate([
            'status_pesanan' => ['required', 'in:disetujui,ditolak'],
        ]);

        $pesanan->update(['status_pesanan' => $request->status_pesanan]);

        return response()->json($pesanan->fresh());
    }

    /**
     * PATCH /penjual/pesanan/{pesanan}/produksi
     * Update status dapur/produksi, terpisah dari status validasi pesanan.
     */
    public function updateProduksi(Request $request, Pesanan $pesanan)
    {
        $this->authorize('updateStatus', $pesanan);

        $request->validate([
            'status_produksi' => ['required', 'in:belum_diproses,diproses,selesai'],
        ]);

        $pesanan->update(['status_produksi' => $request->status_produksi]);

        return response()->json($pesanan->fresh());
    }
}