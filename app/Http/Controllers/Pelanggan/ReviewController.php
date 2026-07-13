<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Pesanan;

class ReviewController extends Controller
{
    /**
     * POST /pelanggan/pesanan/{pesanan}/review
     *
     * Aturan (dicek lewat PesananPolicy@review):
     * - Hanya pemilik pesanan yang boleh review.
     * - Pesanan harus berstatus "selesai" dulu.
     * - 1 pesanan cuma boleh direview sekali (dijaga juga oleh unique constraint di DB).
     */
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

        return response()->json($review, 201);
    }
}