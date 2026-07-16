<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReviewResource;
use App\Models\Review;
use OpenApi\Attributes as OA;

class ReviewController extends Controller
{
    #[OA\Get(
        path: '/api/reviews',
        summary: 'Daftar review/testimoni publik (tidak perlu login)',
        tags: ['Review'],
        responses: [new OA\Response(response: 200, description: 'Daftar review (paginated)')]
    )]
    public function index()
    {
        $reviews = Review::with(['user:id,name', 'pesanan:id,tgl_acara'])
            ->latest()
            ->paginate(10);

        return ReviewResource::collection($reviews);
    }
}