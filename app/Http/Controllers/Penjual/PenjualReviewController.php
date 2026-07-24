<?php

namespace App\Http\Controllers\Penjual;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class PenjualReviewController extends Controller
{
    /**
     * Tampilkan daftar seluruh ulasan / review dari pengguna.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $rating = $request->input('rating');

        $query = Review::with(['user', 'pesanan.pesananPaket.paket']);

        if (!empty($rating) && is_numeric($rating)) {
            $query->where('rating', (int) $rating);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ulasan', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('pesanan', function ($pq) use ($search) {
                      $pq->where('nama_acara', 'like', "%{$search}%");
                  });
            });
        }

        $reviews = $query->latest()->paginate(10)->withQueryString();

        $totalReviews = Review::count();
        $avgRating = Review::avg('rating') ?: 0;
        $fiveStarCount = Review::where('rating', 5)->count();
        $lowRatingCount = Review::whereIn('rating', [1, 2])->count();

        return view('penjual.reviews', compact(
            'reviews',
            'totalReviews',
            'avgRating',
            'fiveStarCount',
            'lowRatingCount',
            'search',
            'rating'
        ));
    }

    /**
     * Hapus ulasan dari sistem.
     */
    public function destroy(Review $review)
    {
        $reviewerName = $review->user->name ?? 'Pengguna';
        $review->delete();

        return redirect()->back()->with('success', "Ulasan dari \"{$reviewerName}\" berhasil dihapus dari sistem.");
    }
}
