<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaukRequest;
use App\Models\Lauk;
use Illuminate\Database\QueryException;

class LaukController extends Controller
{
    /**
     * GET /penjual/lauks
     */
    public function index()
    {
        return response()->json(Lauk::latest()->paginate(15));
    }

    /**
     * POST /penjual/lauks
     */
    public function store(LaukRequest $request)
    {
        $lauk = Lauk::create($request->validated());

        return response()->json($lauk, 201);
    }

    /**
     * GET /penjual/lauks/{lauk}
     */
    public function show(Lauk $lauk)
    {
        return response()->json($lauk);
    }

    /**
     * PUT/PATCH /penjual/lauks/{lauk}
     */
    public function update(LaukRequest $request, Lauk $lauk)
    {
        $lauk->update($request->validated());

        return response()->json($lauk->fresh());
    }

    /**
     * DELETE /penjual/lauks/{lauk}
     * Sama seperti Paket: kalau sudah pernah dipilih di pesanan, DB akan menolak hapus.
     */
    public function destroy(Lauk $lauk)
    {
        try {
            $lauk->delete();
        } catch (QueryException $e) {
            return response()->json([
                'message' => 'Lauk ini tidak bisa dihapus karena sudah pernah dipilih di pesanan. Nonaktifkan saja lewat status_aktif.',
            ], 422);
        }

        return response()->json(['message' => 'Lauk berhasil dihapus.']);
    }
}
