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

            // Otomatis catat data pembayaran DP (50%) untuk pesanan web
            $pesanan->pembayarans()->create([
                'tgl_bayar' => now(),
                'jml_bayar' => $pesanan->total_harga * 0.5,
                'metode_bayar' => 'bank_transfer',
                'status_bayar' => 'diverifikasi',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan Anda berhasil dibuat dan pembayaran DP 50% telah tercatat!',
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

Route::get('/paket/{id}', function ($id) {
    $paket = \App\Models\Paket::findOrFail($id);
    $lauks = \App\Models\Lauk::where('status_aktif', true)->get();
    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman'])->latest()->get() : collect();
    $gubukans = \App\Models\Gubukan::where('status_aktif', true)->get();

    return view('detail', compact('paket', 'lauks', 'myOrders', 'gubukans'));
})->name('paket.show');

Route::get('/checkout', function (\Illuminate\Http\Request $request) {
    $paketId = $request->query('paket_id', 1);
    $paket = \App\Models\Paket::findOrFail($paketId);

    $jumlahPax = (int) $request->query('jumlah_pax', 20);
    $tglAcara = $request->query('tgl_acara', now()->addDay()->toDateString());

    $rawLaukIds = $request->query('lauk_ids');
    $laukIds = $rawLaukIds ? array_map('intval', explode(',', $rawLaukIds)) : [1, 3, 6];
    $selectedLauks = \App\Models\Lauk::whereIn('id', $laukIds)->get();

    $gubukanId = $request->query('gubukan_id');
    $selectedGubukan = $gubukanId ? \App\Models\Gubukan::find($gubukanId) : null;

    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman'])->latest()->get() : collect();

    return view('checkout', compact(
        'paket',
        'jumlahPax',
        'tglAcara',
        'laukIds',
        'selectedLauks',
        'selectedGubukan',
        'myOrders'
    ));
})->middleware('auth')->name('checkout');

Route::get('/pembayaran', function (\Illuminate\Http\Request $request) {
    $paketId = $request->query('paket_id', 1);
    $paket = \App\Models\Paket::findOrFail($paketId);

    $jumlahPax = (int) $request->query('jumlah_pax', 20);
    $tglAcara = $request->query('tgl_acara', now()->addDay()->toDateString());

    $rawLaukIds = $request->query('lauk_ids');
    $laukIds = $rawLaukIds ? array_map('intval', explode(',', $rawLaukIds)) : [1, 3, 6];
    $selectedLauks = \App\Models\Lauk::whereIn('id', $laukIds)->get();

    $gubukanId = $request->query('gubukan_id');
    $selectedGubukan = $gubukanId ? \App\Models\Gubukan::find($gubukanId) : null;

    $alamatPengiriman = $request->query('alamat_pengiriman', '');
    $catatan = $request->query('catatan', '');

    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman'])->latest()->get() : collect();

    return view('pembayaran', compact(
        'paket',
        'jumlahPax',
        'tglAcara',
        'laukIds',
        'selectedLauks',
        'selectedGubukan',
        'alamatPengiriman',
        'catatan',
        'myOrders'
    ));
})->middleware('auth')->name('pembayaran');

Route::get('/pesanan', function () {
    $myOrders = auth()->user()->pesanans()
        ->with(['pesananPaket.paket', 'pesananPaket.lauks.lauk', 'gubukan', 'pembayarans', 'pengiriman'])
        ->latest('tgl_pesan')
        ->get();

    return view('pesanan', compact('myOrders'));
})->middleware('auth')->name('pesanan.index');

Route::post('/pesanan/{pesanan}/batalkan', function (\App\Models\Pesanan $pesanan) {
    if ($pesanan->user_id !== auth()->id()) {
        return response()->json(['success' => false, 'message' => 'Anda tidak memiliki akses ke pesanan ini.'], 403);
    }

    if (in_array(strtolower($pesanan->status_pesanan), ['selesai', 'batal', 'dibatalkan', 'ditolak'])) {
        return response()->json(['success' => false, 'message' => 'Pesanan dengan status ini tidak dapat dibatalkan.'], 422);
    }

    $pesanan->update([
        'status_pesanan' => 'batal'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Pesanan berhasil dibatalkan.'
    ]);
})->middleware('auth')->name('pesanan.batalkan');

Route::get('/pesanan/{pesanan}', function (\App\Models\Pesanan $pesanan) {
    if ($pesanan->user_id !== auth()->id()) {
        abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
    }

    $pesanan->load([
        'pesananPaket.paket',
        'pesananPaket.lauks.lauk',
        'gubukan',
        'pembayarans',
        'pengiriman',
        'user'
    ]);

    $myOrders = auth()->user()->pesanans()->latest()->get();

    return view('pesanan_detail', compact('pesanan', 'myOrders'));
})->middleware('auth')->name('pesanan.show');

Route::get('/penjual/dashboard', function () {
    $totalOrdersCount = \App\Models\Pesanan::count();
    $totalRevenueSum = \App\Models\Pesanan::sum('total_harga');
    
    // Count orders with pending balance or active status
    $pendingPaymentsCount = \App\Models\Pesanan::whereNotIn('status_pesanan', ['selesai', 'batal', 'ditolak'])->count();

    // Deliveries scheduled for today or active
    $todayDeliveriesCount = \App\Models\Pesanan::whereNotIn('status_pesanan', ['selesai', 'batal', 'ditolak'])->count();

    // Recent orders
    $recentOrders = \App\Models\Pesanan::with(['user', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
        ->latest('created_at')
        ->take(10)
        ->get();

    return view('penjual.dashboard', compact(
        'totalOrdersCount',
        'totalRevenueSum',
        'pendingPaymentsCount',
        'todayDeliveriesCount',
        'recentOrders'
    ));
})->middleware(['auth'])->name('penjual.dashboard');

Route::get('/penjual/packages', function () {
    $pakets = \App\Models\Paket::latest()->get();
    $lauks = \App\Models\Lauk::latest()->get();

    $totalPaketsCount = $pakets->count();
    $activePaketsCount = $pakets->where('status_aktif', true)->count();
    $inactivePaketsCount = $pakets->where('status_aktif', false)->count();
    $outOfStockCount = 3;

    return view('penjual.packages', compact(
        'pakets',
        'lauks',
        'totalPaketsCount',
        'activePaketsCount',
        'inactivePaketsCount',
        'outOfStockCount'
    ));
})->middleware(['auth'])->name('penjual.packages');

Route::get('/penjual/orders', function () {
    $orders = \App\Models\Pesanan::with(['user', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
        ->latest('created_at')
        ->get();

    $totalOrders = $orders->count();
    $pendingValidationCount = $orders->where('status_pesanan', 'menunggu_validasi')->count();
    $inPreparationCount = $orders->where('status_produksi', 'diproses')->count();
    $todayRevenueSum = \App\Models\Pesanan::sum('total_harga');

    return view('penjual.orders', compact(
        'orders',
        'totalOrders',
        'pendingValidationCount',
        'inPreparationCount',
        'todayRevenueSum'
    ));
})->middleware(['auth'])->name('penjual.orders');









