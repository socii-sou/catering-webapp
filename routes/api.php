<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Katalog\GubukanController as KatalogGubukanController;
use App\Http\Controllers\Katalog\KategoriController;
use App\Http\Controllers\Katalog\PaketController as KatalogPaketController;
use App\Http\Controllers\Pelanggan\PesananController as PelangganPesananController;
use App\Http\Controllers\Pelanggan\ReviewController as PelangganReviewController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Penjual\CapacitySettingController;
use App\Http\Controllers\Penjual\GubukanController;
use App\Http\Controllers\Penjual\LaporanController;
use App\Http\Controllers\Penjual\LaukController;
use App\Http\Controllers\Penjual\PaketController;
use App\Http\Controllers\Penjual\PesananController as PenjualPesananController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth (publik, tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Publik lainnya (tidak perlu login)
|--------------------------------------------------------------------------
*/
Route::get('/reviews', [ReviewController::class, 'index']);

/*
|--------------------------------------------------------------------------
| Katalog (publik) -- browsing produk sebelum pelanggan login/checkout
|--------------------------------------------------------------------------
*/
Route::prefix('katalog')->group(function () {
    Route::get('/kategori-produk', [KategoriController::class, 'kategoriProduk']);
    Route::get('/kategori-lauk', [KategoriController::class, 'kategoriLauk']);
    Route::get('/pakets', [KatalogPaketController::class, 'index']);
    Route::get('/pakets/{paket}', [KatalogPaketController::class, 'show']);
    Route::get('/gubukans', [KatalogGubukanController::class, 'index']);
});

/*
|--------------------------------------------------------------------------
| Webhook Midtrans
|--------------------------------------------------------------------------
| Sengaja di luar middleware auth:sanctum, karena yang memanggil endpoint
| ini adalah server Midtrans, bukan user yang login.
*/
Route::post('/webhook/midtrans', [PembayaranController::class, 'webhook']);

/*
|--------------------------------------------------------------------------
| Rute yang wajib login (siapapun rolenya)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum,web')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/pesanan/{pesanan}/bayar', [PembayaranController::class, 'createSnapToken']);

    /*
    |----------------------------------------------------------------------
    | Khusus role Pelanggan
    |----------------------------------------------------------------------
    */
    Route::middleware('role:pelanggan')->prefix('pelanggan')->group(function () {
        Route::get('/pesanan', [PelangganPesananController::class, 'index']);
        Route::get('/pesanan/{pesanan}', [PelangganPesananController::class, 'show']);
        Route::post('/pesanan', [PelangganPesananController::class, 'store']);
        Route::patch('/pesanan/{pesanan}/konfirmasi-selesai', [PelangganPesananController::class, 'konfirmasiSelesai']);
        Route::post('/pesanan/{pesanan}/review', [PelangganReviewController::class, 'store']);
    });

    /*
    |----------------------------------------------------------------------
    | Khusus role Penjual
    |----------------------------------------------------------------------
    */
    Route::middleware('role:penjual')->prefix('penjual')->group(function () {
        Route::get('/pesanan', [PenjualPesananController::class, 'index']);
        Route::patch('/pesanan/{pesanan}/validasi', [PenjualPesananController::class, 'validasi']);
        Route::patch('/pesanan/{pesanan}/produksi', [PenjualPesananController::class, 'updateProduksi']);
        Route::get('/laporan', [LaporanController::class, 'index']);

        Route::apiResource('pakets', PaketController::class);
        Route::apiResource('lauks', LaukController::class);
        Route::apiResource('gubukans', GubukanController::class);
        Route::apiResource('capacity-settings', CapacitySettingController::class);
    });
});