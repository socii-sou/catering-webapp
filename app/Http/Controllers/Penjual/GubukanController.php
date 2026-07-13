<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\GubukanRequest;
use App\Models\Gubukan;
use Illuminate\Database\QueryException;

class GubukanController extends Controller
{
    /**
     * GET /penjual/gubukans
     */
    public function index()
    {
        return response()->json(Gubukan::latest()->paginate(15));
    }

    /**
     * POST /penjual/gubukans
     */
    public function store(GubukanRequest $request)
    {
        $gubukan = Gubukan::create($request->validated());

        return response()->json($gubukan, 201);
    }

    /**
     * GET /penjual/gubukans/{gubukan}
     */
    public function show(Gubukan $gubukan)
    {
        return response()->json($gubukan);
    }

    /**
     * PUT/PATCH /penjual/gubukans/{gubukan}
     */
    public function update(GubukanRequest $request, Gubukan $gubukan)
    {
        $gubukan->update($request->validated());

        return response()->json($gubukan->fresh());
    }

    public function destroy(Gubukan $gubukan)
    {
        $gubukan->delete();

        return response()->json(['message' => 'Gubukan berhasil dihapus.']);
    }
}