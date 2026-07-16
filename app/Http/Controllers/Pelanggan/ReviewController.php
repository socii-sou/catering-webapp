<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Resources\ReviewResource;
use App\Models\Pesanan;
use OpenApi\Attributes as OA;

class ReviewController extends Controller
{
    #[OA\Post(
        path: '/api/pelanggan/pesanan/{pesanan}/review',
        summary: 'Beri rating & ulasan untuk pesanan yang sudah selesai',
        description: 'Hanya pemilik pesanan, pesanan harus berstatus "selesai", dan 1 pesanan cuma boleh direview sekali.',
        tags: ['Pelanggan - Review'],
        security: [['bearerAuth' => []]],
        parameters: [new OA\Parameter(name: 'pesanan', in: 'path', required: true, schema: new OA\Schema(type: 'integer'))],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ['rating'],
                properties: [
                    new OA\Property(property: 'rating', type: 'integer', minimum: 1, maximum: 5, example: 5),
                    new OA\Property(property: 'ulasan', type: 'string', nullable: true, example: 'Makanannya enak, pengiriman tepat waktu!'),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: 'Review berhasil disimpan'),
            new OA\Response(response: 403, description: 'Bukan pemilik pesanan atau pesanan belum selesai'),
            new OA\Response(response: 422, description: 'Pesanan ini sudah pernah direview'),
        ]
    )]
    public function store(StoreReviewRequest $request, Pesanan $pesanan)
    {
        $this->authorize('review', $pesanan);

        if ($pesanan->review()->exists()) {
            return response()->json(['message' => 'Pesanan ini sudah pernah kamu review sebelumnya.'], 422);
        }

        $review = $pesanan->review()->create([
            'user_id' => $request->user()->id,
            'rating' => $request->rating,
            'ulasan' => $request->ulasan,
        ]);

        return response()->json(new ReviewResource($review), 201);
    }
}