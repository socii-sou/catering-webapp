<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Http\Requests\CapacitySettingRequest;
use App\Http\Resources\CapacitySettingResource;
use App\Models\CapacitySetting;
use OpenApi\Attributes as OA;

class CapacitySettingController extends Controller
{
    #[OA\Get(
        path: '/api/penjual/capacity-settings',
        summary: 'Daftar pengaturan kapasitas (default global + per tanggal khusus)',
        tags: ['Penjual - Capacity Setting'],
        security: [['bearerAuth' => []]],
        responses: [new OA\Response(response: 200, description: 'Daftar pengaturan kapasitas (paginated)')]
    )]
    public function index()
    {
        return CapacitySettingResource::collection(
            CapacitySetting::orderByRaw('tanggal IS NULL DESC')->orderBy('tanggal')->paginate(20)
        );
    }

    #[OA\Post(
        path: '/api/penjual/capacity-settings',
        summary: 'Tambah pengaturan kapasitas baru',
        description: 'Kosongkan "tanggal" untuk membuat pengaturan default/global (hanya boleh ada 1).',
        tags: ['Penjual - Capacity Setting'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['kapasitas_maks_pax'],
                properties: [
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date', nullable: true, example: '2026-08-17'),
                    new OA\Property(property: 'kapasitas_maks_pax', type: 'integer', example: 500),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Pengaturan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal, atau default global sudah ada'),
        ]
    )]
    public function store(CapacitySettingRequest $request)
    {
        $tanggal = $request->tanggal;

        // Guard tambahan: MySQL tidak menganggap banyak baris NULL sebagai
        // "sama", jadi unique() di migration tidak cukup untuk mencegah
        // lebih dari 1 baris default global. Dicek manual di sini.
        if ($tanggal === null && CapacitySetting::whereNull('tanggal')->exists()) {
            return response()->json([
                'message' => 'Pengaturan kapasitas default (global) sudah ada. Edit yang sudah ada, jangan buat baru.',
            ], 422);
        }

        $capacitySetting = CapacitySetting::create($request->validated());

        return response()->json(new CapacitySettingResource($capacitySetting), 201);
    }

    #[OA\Get(
        path: '/api/penjual/capacity-settings/{capacity_setting}',
        summary: 'Detail 1 pengaturan kapasitas',
        tags: ['Penjual - Capacity Setting'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'capacity_setting', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Detail pengaturan'),
            new OA\Response(response: 404, description: 'Tidak ditemukan'),
        ]
    )]
    public function show(CapacitySetting $capacitySetting)
    {
        return new CapacitySettingResource($capacitySetting);
    }

    #[OA\Put(
        path: '/api/penjual/capacity-settings/{capacity_setting}',
        summary: 'Update pengaturan kapasitas',
        tags: ['Penjual - Capacity Setting'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'capacity_setting', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['kapasitas_maks_pax'],
                properties: [
                    new OA\Property(property: 'tanggal', type: 'string', format: 'date', nullable: true),
                    new OA\Property(property: 'kapasitas_maks_pax', type: 'integer'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: 'Pengaturan berhasil diupdate'),
            new OA\Response(response: 422, description: 'Validasi gagal'),
        ]
    )]
    public function update(CapacitySettingRequest $request, CapacitySetting $capacitySetting)
    {
        $tanggal = $request->tanggal;

        if (
            $tanggal === null
            && $capacitySetting->tanggal !== null
            && CapacitySetting::whereNull('tanggal')->exists()
        ) {
            return response()->json([
                'message' => 'Pengaturan kapasitas default (global) sudah ada di baris lain.',
            ], 422);
        }

        $capacitySetting->update($request->validated());

        return new CapacitySettingResource($capacitySetting->fresh());
    }

    #[OA\Delete(
        path: '/api/penjual/capacity-settings/{capacity_setting}',
        summary: 'Hapus pengaturan kapasitas',
        tags: ['Penjual - Capacity Setting'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'capacity_setting', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [new OA\Response(response: 200, description: 'Berhasil dihapus')]
    )]
    public function destroy(CapacitySetting $capacitySetting)
    {
        $capacitySetting->delete();

        return response()->json(['message' => 'Pengaturan kapasitas berhasil dihapus.']);
    }
}