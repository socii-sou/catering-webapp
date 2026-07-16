<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\LaukRequest;
use App\Http\Resources\LaukResource;
use App\Models\Lauk;
use Illuminate\Database\QueryException;
use OpenApi\Attributes as OA;

class LaukController extends Controller
{
    #[OA\Get(
        path: '/api/penjual/lauks',
        summary: 'Daftar semua lauk',
        tags: ['Penjual - Lauk'],
        security: [['bearerAuth' => []]],
        responses: [new OA\Response(response: 200, description: 'Daftar lauk (paginated)')]
    )]
    public function index()
    {
        return LaukResource::collection(Lauk::latest()->paginate(15));
    }

    #[OA\Post(
        path: '/api/penjual/lauks',
        summary: 'Tambah lauk baru',
        tags: ['Penjual - Lauk'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_lauk'],
                properties: [
                    new OA\Property(property: 'nama_lauk', type: 'string', example: 'Ayam Bakar'),
                    new OA\Property(property: 'keterangan', type: 'string', nullable: true),
                    new OA\Property(property: 'status_aktif', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Lauk berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(LaukRequest $request)
    {
        $lauk = Lauk::create($request->validated());

        return response()->json(new LaukResource($lauk), 201);
    }

    #[OA\Get(
        path: '/api/penjual/lauks/{lauk}',
        summary: 'Detail 1 lauk',
        tags: ['Penjual - Lauk'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'lauk', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Detail lauk'),
            new OA\Response(response: 404, description: 'Tidak ditemukan'),
        ]
    )]
    public function show(Lauk $lauk)
    {
        return new LaukResource($lauk);
    }

    #[OA\Put(
        path: '/api/penjual/lauks/{lauk}',
        summary: 'Update lauk',
        tags: ['Penjual - Lauk'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'lauk', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_lauk'],
                properties: [
                    new OA\Property(property: 'nama_lauk', type: 'string'),
                    new OA\Property(property: 'keterangan', type: 'string', nullable: true),
                    new OA\Property(property: 'status_aktif', type: 'boolean'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Lauk berhasil diupdate'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function update(LaukRequest $request, Lauk $lauk)
    {
        $lauk->update($request->validated());

        return new LaukResource($lauk->fresh());
    }

    #[OA\Delete(
        path: '/api/penjual/lauks/{lauk}',
        summary: 'Hapus lauk',
        description: 'Ditolak (422) kalau lauk ini sudah pernah dipilih di pesanan.',
        tags: ['Penjual - Lauk'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'lauk', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Lauk berhasil dihapus'),
            new OA\Response(response: 422, description: 'Sudah pernah dipilih di pesanan'),
        ]
    )]
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