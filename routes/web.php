<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Models\Paket;
use App\Models\Review;
use App\Models\Lauk;
use App\Models\Gubukan;
use App\Http\Requests\StorePesananRequest;
use App\Services\PesananService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $pakets = Paket::where('status_aktif', true)->get();
    $reviews = Review::with('user')->latest()->take(6)->get();
    $lauks = Lauk::where('status_aktif', true)->get();
    $gubukans = Gubukan::where('status_aktif', true)->get();
    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman'])->latest()->get() : collect();

    return view('welcome', compact('pakets', 'reviews', 'lauks', 'gubukans', 'myOrders'));
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');
    
    // Rute pemesanan via web landing page
    Route::post('/pesanan', function (StorePesananRequest $request, PesananService $pesananService) {
        try {
            $pesanan = $pesananService->store($request->user(), $request->validated());
            return response()->json([
                'success' => true,
                'message' => 'Pesanan Anda berhasil dibuat! Tim kami akan segera menghubungi Anda.',
                'pesanan' => $pesanan
            ]);
        } catch (\App\Exceptions\KapasitasTerlampauiException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    })->middleware('role:pelanggan')->name('web.pesanan.store');
});
