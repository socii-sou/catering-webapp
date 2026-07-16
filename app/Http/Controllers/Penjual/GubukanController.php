<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\GubukanRequest;
use App\Http\Resources\GubukanResource;
use App\Models\Gubukan;
use Illuminate\Database\QueryException;
use OpenApi\Attributes as OA;

class GubukanController extends Controller
{
    #[OA\Get(
        path: '/api/penjual/gubukans',
        summary: 'Daftar semua gubukan',
        tags: ['Penjual - Gubukan'],
        security: [['bearerAuth' => []]],
        responses: [new OA\Response(response: 200, description: 'Daftar gubukan (paginated)')]
    )]
    public function index()
    {
        return GubukanResource::collection(Gubukan::latest()->paginate(15));
    }

    #[OA\Post(
        path: '/api/penjual/gubukans',
        summary: 'Tambah gubukan baru',
        tags: ['Penjual - Gubukan'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_gubukan', 'harga_gubukan', 'kapasitas_orang'],
                properties: [
                    new OA\Property(property: 'nama_gubukan', type: 'string', example: 'Gubukan Sedang'),
                    new OA\Property(property: 'harga_gubukan', type: 'number', format: 'float', example: 250000),
                    new OA\Property(property: 'kapasitas_orang', type: 'integer', example: 25),
                    new OA\Property(property: 'status_aktif', type: 'boolean', example: true),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Gubukan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function store(GubukanRequest $request)
    {
        $gubukan = Gubukan::create($request->validated());

        return response()->json(new GubukanResource($gubukan), 201);
    }

    #[OA\Get(
        path: '/api/penjual/gubukans/{gubukan}',
        summary: 'Detail 1 gubukan',
        tags: ['Penjual - Gubukan'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'gubukan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Detail gubukan'),
            new OA\Response(response: 404, description: 'Tidak ditemukan'),
        ]
    )]
    public function show(Gubukan $gubukan)
    {
        return new GubukanResource($gubukan);
    }

    #[OA\Put(
        path: '/api/penjual/gubukans/{gubukan}',
        summary: 'Update gubukan',
        tags: ['Penjual - Gubukan'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'gubukan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['nama_gubukan', 'harga_gubukan', 'kapasitas_orang'],
                properties: [
                    new OA\Property(property: 'nama_gubukan', type: 'string'),
                    new OA\Property(property: 'harga_gubukan', type: 'number', format: 'float'),
                    new OA\Property(property: 'kapasitas_orang', type: 'integer'),
                    new OA\Property(property: 'status_aktif', type: 'boolean'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Gubukan berhasil diupdate'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function update(GubukanRequest $request, Gubukan $gubukan)
    {
        $gubukan->update($request->validated());

        return new GubukanResource($gubukan->fresh());
    }

    #[OA\Delete(
        path: '/api/penjual/gubukans/{gubukan}',
        summary: 'Hapus gubukan',
        description: 'Aman dihapus meski sudah pernah dipakai di pesanan lama (gubukan_id di pesanan itu otomatis jadi NULL, pesanannya tidak ikut terhapus).',
        tags: ['Penjual - Gubukan'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'gubukan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Gubukan berhasil dihapus')]
    )]
    public function destroy(Gubukan $gubukan)
    {
        $gubukan->delete();

        return response()->json(['message' => 'Gubukan berhasil dihapus.']);
    }
}