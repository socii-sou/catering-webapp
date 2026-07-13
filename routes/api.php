<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Pelanggan\PesananController as PelangganPesananController;
use App\Http\Controllers\Pelanggan\ReviewController as PelangganReviewController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Penjual\GubukanController;
use App\Http\Controllers\Penjual\LaporanController;
use App\Http\Controllers\Penjual\LaukController;
use App\Http\Controllers\Penjual\PaketController;
use App\Http\Controllers\Penjual\PesananController as PenjualPesananController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/reviews', [ReviewController::class, 'index']);


Route::post('/webhook/midtrans', [PembayaranController::class, 'webhook']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/pesanan/{pesanan}/bayar', [PembayaranController::class, 'createSnapToken']);

    Route::middleware('role:pelanggan')->prefix('pelanggan')->group(function () {
        Route::get('/pesanan', [PelangganPesananController::class, 'index']);
        Route::get('/pesanan/{pesanan}', [PelangganPesananController::class, 'show']);
        Route::post('/pesanan', [PelangganPesananController::class, 'store']);
        Route::post('/pesanan/{pesanan}/review', [PelangganReviewController::class, 'store']);
    });

    Route::middleware('role:penjual')->prefix('penjual')->group(function () {
        Route::get('/pesanan', [PenjualPesananController::class, 'index']);
        Route::patch('/pesanan/{pesanan}/validasi', [PenjualPesananController::class, 'validasi']);
        Route::patch('/pesanan/{pesanan}/produksi', [PenjualPesananController::class, 'updateProduksi']);
        Route::get('/laporan', [LaporanController::class, 'index']);

        Route::apiResource('pakets', PaketController::class);
        Route::apiResource('lauks', LaukController::class);
        Route::apiResource('gubukans', GubukanController::class);
    });
});