<?php

namespace App\Http\Controllers\Pelanggan;

use App\Exceptions\KapasitasTerlampauiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePesananRequest;
use App\Models\Pesanan;
use App\Services\PesananService;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function __construct(protected PesananService $pesananService)
    {
    }

    /**
     * GET /pelanggan/pesanan
     * Riwayat pesanan milik pelanggan yang sedang login.
     */
    public function index(Request $request)
    {
        $pesanans = $request->user()
            ->pesanans()
            ->with(['gubukan', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
            ->latest('tgl_pesan')
            ->paginate(10);

        return response()->json($pesanans);
    }

    /**
     * GET /pelanggan/pesanan/{pesanan}
     * Detail 1 pesanan (hanya boleh diakses pemiliknya).
     */
    public function show(Request $request, Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);

        return response()->json(
            $pesanan->load([
                'gubukan',
                'pesananPaket.paket',
                'pesananPaket.lauks.lauk',
                'pembayarans',
                'pengiriman',
                'review',
            ])
        );
    }

    /**
     * POST /pelanggan/pesanan
     * Bikin pesanan baru: pilih paket + lauk + gubukan + jumlah pax + tanggal acara.
     */
    public function store(StorePesananRequest $request)
    {
        $this->authorize('create', Pesanan::class);

        try {
            $pesanan = $this->pesananService->store($request->user(), $request->validated());
        } catch (KapasitasTerlampauiException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json($pesanan, 201);
    }
}