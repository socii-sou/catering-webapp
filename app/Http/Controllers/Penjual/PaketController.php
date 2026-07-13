<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaketRequest;
use App\Models\Paket;
use Illuminate\Database\QueryException;

class PaketController extends Controller
{
    /**
     * GET /penjual/pakets
     */
    public function index()
    {
        return response()->json(Paket::latest()->paginate(15));
    }

    /**
     * POST /penjual/pakets
     */
    public function store(PaketRequest $request)
    {
        $paket = Paket::create($request->validated());

        return response()->json($paket, 201);
    }

    /**
     * GET /penjual/pakets/{paket}
     */
    public function show(Paket $paket)
    {
        return response()->json($paket);
    }

    /**
     * PUT/PATCH /penjual/pakets/{paket}
     */
    public function update(PaketRequest $request, Paket $paket)
    {
        $paket->update($request->validated());

        return response()->json($paket->fresh());
    }

    /**
     * DELETE /penjual/pakets/{paket}
     *
     * Kalau paket ini sudah pernah dipesan (ada baris di pesanan_paket),
     * DB akan menolak penghapusan karena foreign key restrictOnDelete().
     * Di sini kita tangkap errornya dan kasih pesan yang lebih ramah,
     * plus saran alternatif: nonaktifkan saja lewat status_aktif.
     */
    public function destroy(Paket $paket)
    {
        try {
            $paket->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Paket ini tidak bisa dihapus karena sudah pernah dipesan. Nonaktifkan saja lewat status_aktif.',
            ], 422);
        }

        return response()->json(['message' => 'Paket berhasil dihapus.']);
    }
}