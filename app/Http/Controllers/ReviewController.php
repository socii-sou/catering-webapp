<?php

namespace App\Http\Controllers;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with(['user:id,name', 'pesanan:id,tgl_acara'])
            ->latest()
            ->paginate(10);

        return response()->json($reviews);
    }
}