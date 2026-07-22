<?php

namespace App\Http\Controllers\Pelanggan;

use App\Exceptions\KapasitasTerlampauiException;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePesananRequest;
use App\Http\Resources\PesananResource;
use App\Models\Pesanan;
use App\Services\PesananService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class PesananController extends Controller
{
    public function __construct(protected PesananService $pesananService)
    {
    }

    #[OA\Get(
        path: '/api/pelanggan/pesanan',
        summary: 'Riwayat pesanan milik pelanggan yang sedang login',
        tags: ['Pelanggan - Pesanan'],
        security: [['bearerAuth' => []]],
        responses: [
            new OA\Response(response: 200, description: 'Daftar pesanan (paginated)'),
            new OA\Response(response: 401, description: 'Belum login'),
            new OA\Response(response: 403, description: 'Bukan role pelanggan'),
        ]
    )]
    public function index(Request $request)
    {
        $pesanans = $request->user()
            ->pesanans()
            ->with(['gubukan', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
            ->latest('tgl_pesan')
            ->paginate(10);

        return PesananResource::collection($pesanans);
    }

    #[OA\Get(
        path: '/api/pelanggan/pesanan/{pesanan}',
        summary: 'Detail 1 pesanan milik sendiri',
        tags: ['Pelanggan - Pesanan'],
        security: [['bearerAuth' => []]],
        parameters: [
            new OA\Parameter(name: 'pesanan', in: 'path', required: true, description: 'ID pesanan', schema: new OA\Schema(type: 'integer')),
        ],
        responses: [
            new OA\Response(response: 200, description: 'Detail pesanan lengkap'),
            new OA\Response(response: 403, description: 'Bukan pemilik pesanan ini'),
            new OA\Response(response: 404, description: 'Pesanan tidak ditemukan'),
        ]
    )]
    public function show(Request $request, Pesanan $pesanan)
    {
        $this->authorize('view', $pesanan);

        $pesanan->load([
            'gubukan',
            'pesananPaket.paket',
            'pesananPaket.lauks.lauk',
            'pembayarans',
            'pengiriman',
            'review',
        ]);

        return new PesananResource($pesanan);
    }

    #[OA\Post(
        path: '/api/pelanggan/pesanan',
        summary: 'Bikin pesanan baru (pilih paket + lauk + gubukan + jumlah pax + tanggal acara)',
        tags: ['Pelanggan - Pesanan'],
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['tgl_acara', 'jumlah_pax', 'items'],
                properties: [
                    new OA\Property(property: 'gubukan_id', type: 'integer', nullable: true, example: 1),
                    new OA\Property(property: 'tgl_acara', type: 'string', format: 'date', example: '2026-08-20'),
                    new OA\Property(property: 'jumlah_pax', type: 'integer', example: 50),
                    new OA\Property(property: 'catatan', type: 'string', nullable: true, example: 'Tolong pedas sedang'),
                    new OA\Property(
                        property: 'items',
                        type: 'array',
                        items: new OA\Items(
                            properties: [
                                new OA\Property(property: 'paket_id', type: 'integer', example: 2),
                                new OA\Property(property: 'jml_paket', type: 'integer', example: 50),
                                new OA\Property(
                                    property: 'lauk_ids',
                                    type: 'array',
                                    items: new OA\Items(type: 'integer'),
                                    example: [1, 2, 3, 4, 5]
                                ),
                            ]
                        )
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Pesanan berhasil dibuat'),
            new OA\Response(response: 422, description: 'Validasi gagal atau kapasitas tanggal tersebut sudah penuh'),
        ]
    )]
    public function store(StorePesananRequest $request)
    {
        $this->authorize('create', Pesanan::class);

        try {
            $pesanan = $this->pesananService->store($request->user(), $request->validated());
        } catch (KapasitasTerlampauiException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }

        return response()->json(new PesananResource($pesanan), 201);
    }

    #[OA\Patch(
        path: '/api/pelanggan/pesanan/{pesanan}/konfirmasi-selesai',
        summary: 'Konfirmasi pesanan sudah diterima -- ini yang membuka akses untuk kasih review',
        description: 'Hanya bisa dipanggil kalau status_pesanan sedang "disetujui". Setelah ini status_pesanan berubah jadi "selesai", dan endpoint POST .../review baru bisa dipakai.',
        tags: ['Pelanggan - Pesanan'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'pesanan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        responses: [
            new OA\Response(response: 200, description: 'Pesanan berhasil ditandai selesai'),
            new OA\Response(response: 403, description: 'Bukan pemilik pesanan, atau status pesanan belum "disetujui"'),
        ]
    )]
    public function konfirmasiSelesai(Request $request, Pesanan $pesanan)
    {
        $this->authorize('confirmSelesai', $pesanan);

        $pesanan->update(['status_pesanan' => 'selesai']);

        return new PesananResource($pesanan->fresh());
    }
}