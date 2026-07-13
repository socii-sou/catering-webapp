<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * GET /penjual/laporan?tgl_awal=2026-07-01&tgl_akhir=2026-07-31
     * Laporan penjualan untuk rentang tanggal tertentu.
     */
    public function index(Request $request)
    {
        $request->validate([
            'tgl_awal' => ['required', 'date'],
            'tgl_akhir' => ['required', 'date', 'after_or_equal:tgl_awal'],
        ]);

        $pesanans = Pesanan::with([
                'user:id,name,email',
                'pesananPaket.paket',
                'pembayarans' => fn ($q) => $q->where('status_bayar', 'lunas'),
            ])
            ->whereBetween('tgl_pesan', [$request->tgl_awal, $request->tgl_akhir])
            ->where('status_pesanan', '!=', 'batal')
            ->orderBy('tgl_pesan')
            ->get();

        $ringkasan = [
            'jumlah_pesanan' => $pesanans->count(),
            'total_pax' => $pesanans->sum('jumlah_pax'),
            'total_pendapatan' => $pesanans->sum(fn ($p) => $p->pembayarans->sum('jml_bayar')),
        ];

        return response()->json([
            'periode' => [
                'tgl_awal' => $request->tgl_awal,
                'tgl_akhir' => $request->tgl_akhir,
            ],
            'ringkasan' => $ringkasan,
            'data' => $pesanans,
        ]);
    }
}
