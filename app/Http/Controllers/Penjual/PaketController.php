<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\PaketRequest;
use App\Http\Resources\PaketResource;
use App\Models\Paket;
use Illuminate\Database\QueryException;
use OpenApi\Attributes as OA;

class PaketController extends Controller
{
    #[OA\Get(
        path: '/api/penjual/pakets',
        summary: 'Daftar semua paket (dikelola Penjual)',
        tags: ['Penjual - Paket'],
        security: [['bearerAuth' => []]],
        responses: [new OA\Response(response: 200, description: 'Daftar paket (paginated)')]
    )]
    public function index()
    {
        return PaketResource::collection(Paket::latest()->paginate(15));
    }

    #[OA\Post(
        path: '/api/penjual/pakets',
        summary: 'Tambah paket baru',
        tags: ['Penjual - Paket'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nm_paket', 'harga_paket', 'jumlah_lauk_pilihan'],
                properties: [
                    new OA\Property(property: 'nm_paket', type: 'string', example: 'Prasmanan'),
                    new OA\Property(property: 'harga_paket', type: 'number', format: 'float', example: 50000),
                    new OA\Property(property: 'jumlah_lauk_pilihan', type: 'integer', example: 5),
                    new OA\Property(property: 'deskripsi', type: 'string', nullable: true, example: 'Pilih 5 dari 10 lauk'),
                    new OA\Property(property: 'status_aktif', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Paket berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal (mis. nama paket sudah dipakai)'),
        ]
    )]
    public function store(PaketRequest $request)
    {
        $paket = Paket::create($request->validated());

        return response()->json(new PaketResource($paket), 201);
    }

    #[OA\Get(
        path: '/api/penjual/pakets/{paket}',
        summary: 'Detail 1 paket',
        tags: ['Penjual - Paket'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'paket', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail paket'),
            new OA\Response(response: 404, description: 'Paket tidak ditemukan'),
        ]
    )]
    public function show(Paket $paket)
    {
        return new PaketResource($paket);
    }

    #[OA\Put(
        path: '/api/penjual/pakets/{paket}',
        summary: 'Update paket',
        tags: ['Penjual - Paket'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'paket', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nm_paket', 'harga_paket', 'jumlah_lauk_pilihan'],
                properties: [
                    new OA\Property(property: 'nm_paket', type: 'string', example: 'Prasmanan'),
                    new OA\Property(property: 'harga_paket', type: 'number', format: 'float', example: 55000),
                    new OA\Property(property: 'jumlah_lauk_pilihan', type: 'integer', example: 5),
                    new OA\Property(property: 'deskripsi', type: 'string', nullable: true),
                    new OA\Property(property: 'status_aktif', type: 'boolean'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Paket berhasil diupdate'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function update(PaketRequest $request, Paket $paket)
    {
        $paket->update($request->validated());

        return new PaketResource($paket->fresh());
    }

    #[OA\Delete(
        path: '/api/penjual/pakets/{paket}',
        summary: 'Hapus paket',
        description: 'Ditolak (422) kalau paket ini sudah pernah dipesan — nonaktifkan lewat status_aktif sebagai gantinya.',
        tags: ['Penjual - Paket'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'paket', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Paket berhasil dihapus'),
            new OA\Response(response: 422, description: 'Paket sudah pernah dipesan, tidak bisa dihapus'),
        ]
    )]
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