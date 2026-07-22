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
    $reviews = Review::with('user')->whereNotNull('ulasan')->where('ulasan', '!=', '')->latest()->take(6)->get();
    $lauks = Lauk::where('status_aktif', true)->get();
    $gubukans = Gubukan::where('status_aktif', true)->get();
    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman', 'review'])->latest()->get() : collect();

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

            $buktiPath = null;
            if ($request->hasFile('bukti_bayar')) {
                $buktiPath = $request->file('bukti_bayar')->store('bukti_bayar', 'public');
            }

            $metodeChoice = $request->input('metode_pembayaran_choice', 'midtrans');

            if ($metodeChoice === 'manual') {
                $pesanan->pembayarans()->create([
                    'tgl_bayar' => now(),
                    'jml_bayar' => $pesanan->total_harga * 0.5,
                    'metode_bayar' => 'bank_transfer',
                    'status_bayar' => 'diverifikasi',
                    'bukti_bayar' => $buktiPath,
                ]);

                $pesanan->update(['status_pesanan' => 'dikonfirmasi']);
                $message = 'Pesanan Anda berhasil dibuat dan pembayaran DP telah diverifikasi secara otomatis!';
            } else {
                $pesanan->update(['status_pesanan' => 'menunggu_validasi']);
                $message = 'Pesanan Anda berhasil dibuat! Silakan lanjutkan pembayaran.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
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
    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman', 'review'])->latest()->get() : collect();
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

    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman', 'review'])->latest()->get() : collect();

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

    $myOrders = auth()->check() ? auth()->user()->pesanans()->with(['pesananPaket.paket', 'pembayarans', 'pengiriman', 'review'])->latest()->get() : collect();

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
        ->with(['pesananPaket.paket', 'pesananPaket.lauks.lauk', 'gubukan', 'pembayarans', 'pengiriman', 'review'])
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
        'user',
        'review'
    ]);

    $myOrders = auth()->user()->pesanans()->latest()->get();

    return view('pesanan_detail', compact('pesanan', 'myOrders'));
})->middleware('auth')->name('pesanan.show');

Route::post('/pesanan/{pesanan}/review', function (\App\Models\Pesanan $pesanan, \Illuminate\Http\Request $request) {
    if ($pesanan->user_id !== auth()->id() || $pesanan->status_pesanan !== 'selesai') {
        abort(403, 'Aksi tidak diizinkan.');
    }

    $request->validate([
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
        'ulasan' => ['nullable', 'string', 'max:1000'],
    ]);

    // Make sure we only allow 1 review per order
    if ($pesanan->review()->exists()) {
        return redirect()->back()->with('error', 'Pesanan ini sudah pernah direview sebelumnya.');
    }

    $pesanan->review()->create([
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'ulasan' => $request->ulasan,
    ]);

    return redirect()->back()->with('success', 'Ulasan Anda berhasil dikirim. Terima kasih banyak!');
})->middleware('auth')->name('pesanan.review.store');

Route::post('/pesanan/{pesanan}/bayar', [\App\Http\Controllers\PembayaranController::class, 'createSnapToken'])->middleware('auth')->name('pesanan.bayar');

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
    $gubukans = \App\Models\Gubukan::latest()->get();

    $totalPaketsCount = $pakets->count();
    $activePaketsCount = $pakets->where('status_aktif', true)->count();
    $inactivePaketsCount = $pakets->where('status_aktif', false)->count();
    $outOfStockCount = 3;

    return view('penjual.packages', compact(
        'pakets',
        'lauks',
        'gubukans',
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

Route::get('/penjual/orders/{pesanan}/validasi', function (\App\Models\Pesanan $pesanan) {
    $pesanan->load([
        'pesananPaket.paket',
        'pesananPaket.lauks.lauk',
        'gubukan',
        'pembayarans',
        'pengiriman',
        'user'
    ]);

    return view('penjual.validasi', compact('pesanan'));
})->middleware(['auth'])->name('penjual.orders.validasi');

Route::post('/penjual/orders/{pesanan}/validasi-action', function (\App\Models\Pesanan $pesanan, \Illuminate\Http\Request $request) {
    $action = $request->input('action');

    if ($action === 'approve') {
        $pesanan->pembayarans()->firstOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'tgl_bayar' => now(),
                'jml_bayar' => $pesanan->total_harga * 0.5,
                'metode_bayar' => 'bank_transfer',
                'status_bayar' => 'diverifikasi'
            ]
        )->update(['status_bayar' => 'diverifikasi']);

        $pesanan->update(['status_pesanan' => 'disetujui']);

        return redirect()->back()->with('success', 'Pembayaran DP 50% berhasil divalidasi dan pesanan telah disetujui!');
    } elseif ($action === 'reject') {
        $pesanan->pembayarans()->update(['status_bayar' => 'ditolak']);
        $pesanan->update(['status_pesanan' => 'ditolak']);

        return redirect()->back()->with('error', 'Pembayaran telah ditolak.');
    }

    return redirect()->back();
})->middleware(['auth'])->name('penjual.orders.validasi.action');

Route::get('/penjual/reports', function () {
    $transactions = \App\Models\Pesanan::with(['user', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
        ->latest('created_at')
        ->get();

    $totalSalesSum = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'ditolak'])->sum('total_harga');
    $totalOrdersCount = $transactions->count();
    $avgOrderValue = $totalOrdersCount > 0 ? round($totalSalesSum / $totalOrdersCount) : 0;

    $popularPaket = \App\Models\Paket::withCount('pesananPaket')->orderBy('pesanan_paket_count', 'desc')->first();
    $popularPaketName = $popularPaket ? $popularPaket->nm_paket : 'Royal Wedding Buffet';

    return view('penjual.reports', compact(
        'transactions',
        'totalSalesSum',
        'totalOrdersCount',
        'avgOrderValue',
        'popularPaketName'
    ));
})->middleware(['auth'])->name('penjual.reports');











