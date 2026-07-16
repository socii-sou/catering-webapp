<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class LaporanController extends Controller
{
    #[OA\Get(
        path: '/api/penjual/laporan',
        summary: 'Laporan penjualan untuk rentang tanggal tertentu',
        tags: ['Penjual - Laporan'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'tgl_awal', in: 'query', required: true, schema: new OA\Schema(type: 'string', format: 'date'), example: '2026-07-01'),
            new OA\Parameter(name: 'tgl_akhir', in: 'query', required: true, schema: new OA\Schema(type: 'string', format: 'date'), example: '2026-07-31'),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Ringkasan + detail pesanan pada periode tersebut'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
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
            'data' => PesananResource::collection($pesanans),
        ]);
    }
}
