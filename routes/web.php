<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ProfileController;
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

Route::get('/test-welcome-email', function () {
    $dummyUser = new \App\Models\User();
    $dummyUser->name = 'aci';
    $dummyUser->email = 'ascii99932@gmail.com';

    try {
        \Illuminate\Support\Facades\Mail::to('ascii99932@gmail.com')->send(new \App\Mail\WelcomeMail($dummyUser));
        return 'Email selamat datang berhasil dikirim ke ascii99932@gmail.com!';
    } catch (\Throwable $e) {
        return 'Gagal mengirim email: ' . $e->getMessage();
    }
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [WebAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [WebAuthController::class, 'login']);
    Route::get('/register', [WebAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [WebAuthController::class, 'register']);

    // Google OAuth Routes
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirectToGoogle'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    // Rute Pengaturan & Profil Pelanggan
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    // Rute pemesanan via web landing page
    Route::post('/pesanan', function (StorePesananRequest $request, PesananService $pesananService) {
        try {
            $pesanan = $pesananService->store($request->user(), $request->validated());

            $pesanan->update(['status_pesanan' => 'menunggu_validasi']);

            return response()->json([
                'success' => true,
                'message' => 'Pesanan Anda berhasil dibuat! Silakan lakukan pembayaran DP via Payment Gateway.',
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
    $jumlahPaxGubukan = max(100, (int) $request->query('jumlah_pax_gubukan', 100));
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
        'jumlahPaxGubukan',
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
    $jumlahPaxGubukan = max(100, (int) $request->query('jumlah_pax_gubukan', 100));
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
        'jumlahPaxGubukan',
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

    // Sinkronisasi status pembayaran pending langsung ke Midtrans sebelum merender halaman
    $pendingPembayarans = $pesanan->pembayarans()->where('status_bayar', 'pending')->get();
    if ($pendingPembayarans->isNotEmpty()) {
        $midtrans = app(\App\Services\MidtransService::class);
        foreach ($pendingPembayarans as $pembayaran) {
            $statusData = $midtrans->getTransactionStatus($pembayaran->transaction_id);
            if ($statusData) {
                $transactionStatus = $statusData['transaction_status'] ?? '';
                $fraudStatus = $statusData['fraud_status'] ?? '';

                $statusBayar = match (true) {
                    $transactionStatus === 'capture' && $fraudStatus === 'accept' => ($pembayaran->jenis_pembayaran === 'dp' ? 'diverifikasi' : 'lunas'),
                    $transactionStatus === 'settlement' => ($pembayaran->jenis_pembayaran === 'dp' ? 'diverifikasi' : 'lunas'),
                    in_array($transactionStatus, ['deny', 'cancel', 'expire']) => 'gagal',
                    $transactionStatus === 'pending' => 'pending',
                    default => $pembayaran->status_bayar,
                };

                if ($statusBayar !== $pembayaran->status_bayar) {
                    $pembayaran->update(['status_bayar' => $statusBayar]);
                    if ($statusBayar === 'lunas') {
                        $pesanan->update(['status_pesanan' => 'selesai']);
                    } elseif ($statusBayar === 'diverifikasi') {
                        if (in_array($pesanan->status_pesanan, ['menunggu_validasi', 'pending'])) {
                            $pesanan->update(['status_pesanan' => 'dikonfirmasi']);
                        }
                    }
                }
            }
        }
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

Route::get('/pesanan/{pesanan}/review', function (\App\Models\Pesanan $pesanan) {
    if ($pesanan->user_id !== auth()->id()) {
        abort(403);
    }

    if ($pesanan->status_pesanan !== 'selesai') {
        return redirect()->route('pesanan.show', $pesanan->id)->with('error', 'Anda hanya bisa memberikan ulasan setelah pesanan selesai.');
    }

    if ($pesanan->review()->exists()) {
        return redirect()->route('pesanan.show', $pesanan->id)->with('error', 'Pesanan ini sudah Anda ulas.');
    }

    return view('review', compact('pesanan'));
})->middleware('auth')->name('pesanan.review.create');

Route::post('/pesanan/{pesanan}/selesai', function (\App\Models\Pesanan $pesanan) {
    if ($pesanan->user_id !== auth()->id() || !in_array(strtolower($pesanan->status_pesanan), ['disetujui', 'dikonfirmasi'])) {
        abort(403, 'Aksi tidak diizinkan.');
    }

    $hasPelunasan = $pesanan->pembayarans()
        ->where('jenis_pembayaran', 'pelunasan')
        ->whereIn('status_bayar', ['diverifikasi', 'lunas', 'settlement', 'success'])
        ->exists();

    if (!$hasPelunasan) {
        return redirect()->back()->with('error', 'Pesanan belum dapat diselesaikan. Silakan lakukan pelunasan (50% sisa) terlebih dahulu.');
    }

    $pesanan->update(['status_pesanan' => 'selesai']);

    return redirect()->route('pesanan.review.create', $pesanan->id)->with('success', 'Pesanan ditandai selesai! Silakan berikan ulasan Anda.');
})->middleware('auth')->name('pesanan.selesai');

Route::post('/pesanan/{pesanan}/review', function (\App\Models\Pesanan $pesanan, \Illuminate\Http\Request $request) {
    if ($pesanan->user_id !== auth()->id() || $pesanan->status_pesanan !== 'selesai') {
        abort(403, 'Aksi tidak diizinkan.');
    }

    $request->validate([
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
        'ulasan' => ['nullable', 'string', 'max:1000'],
    ]);

    if ($pesanan->review()->exists()) {
        return redirect()->route('pesanan.show', $pesanan->id)->with('error', 'Pesanan ini sudah pernah direview sebelumnya.');
    }

    $pesanan->review()->create([
        'user_id' => auth()->id(),
        'rating' => $request->rating,
        'ulasan' => $request->ulasan,
    ]);

    return redirect()->route('pesanan.show', $pesanan->id)->with('success', 'Ulasan Anda berhasil dikirim. Terima kasih banyak!');
})->middleware('auth')->name('pesanan.review.store');

Route::post('/pesanan/{pesanan}/bayar', [\App\Http\Controllers\PembayaranController::class, 'createSnapToken'])->middleware('auth')->name('pesanan.bayar');

Route::get('/penjual/dashboard', function () {
    $totalOrdersCount = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])->count();
    $totalRevenueSum = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])->sum('total_harga');

    // Count orders with pending validation status
    $pendingPaymentsCount = \App\Models\Pesanan::where('status_pesanan', 'menunggu_validasi')->count();

    // Active deliveries
    $todayDeliveriesCount = \App\Models\Pengiriman::where('status_pengiriman', 'dikirim')->count();

    // Recent orders (excluding cancelled/rejected orders)
    $recentOrders = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])
        ->with(['user', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
        ->latest('created_at')
        ->take(10)
        ->get();

    // Capacity calculation
    $maxCapacity = \App\Models\CapacitySetting::whereNull('tanggal')->value('kapasitas_maks_pax') ?? 1000;
    $paxToday = \App\Models\Pesanan::whereIn('status_pesanan', ['menunggu_validasi', 'disetujui'])
        ->whereDate('tgl_acara', now()->toDateString())
        ->sum('jumlah_pax');
    $capacityPctToday = $maxCapacity > 0 ? min(round(($paxToday / $maxCapacity) * 100), 100) : 0;
    $sisaKapasitasToday = max(0, $maxCapacity - $paxToday);

    // Weekly sales (revenue per day for the current week)
    $daysOfWeek = [
        'Mon' => 0, 'Tue' => 0, 'Wed' => 0, 'Thu' => 0, 'Fri' => 0, 'Sat' => 0, 'Sun' => 0
    ];
    $startOfWeek = now()->startOfWeek();
    $endOfWeek = now()->endOfWeek();

    $ordersThisWeek = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])
        ->whereBetween('tgl_pesan', [$startOfWeek, $endOfWeek])
        ->get();

    foreach ($ordersThisWeek as $order) {
        $dayName = $order->tgl_pesan->format('D');
        // Map to Mon-Sun
        if (isset($daysOfWeek[$dayName])) {
            $daysOfWeek[$dayName] += $order->total_harga;
        }
    }

    $maxWeeklyRevenue = max($daysOfWeek);
    $weeklyPercentages = [];
    foreach ($daysOfWeek as $day => $rev) {
        $weeklyPercentages[$day] = $maxWeeklyRevenue > 0 ? round(($rev / $maxWeeklyRevenue) * 100) : 0;
    }

    return view('penjual.dashboard', compact(
        'totalOrdersCount',
        'totalRevenueSum',
        'pendingPaymentsCount',
        'todayDeliveriesCount',
        'recentOrders',
        'capacityPctToday',
        'sisaKapasitasToday',
        'maxCapacity',
        'paxToday',
        'daysOfWeek',
        'weeklyPercentages'
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
    $orders = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])
        ->with(['user', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
        ->latest('created_at')
        ->get();

    $totalOrders = $orders->count();
    $pendingValidationCount = $orders->where('status_pesanan', 'menunggu_validasi')->count();
    $inPreparationCount = $orders->where('status_produksi', 'diproses')->count();
    $todayRevenueSum = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])->sum('total_harga');

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

Route::post('/penjual/orders/{pesanan}/update-status', function (\App\Models\Pesanan $pesanan, \Illuminate\Http\Request $request) {
    $stage = $request->input('stage');

    $currentStatus = strtolower($pesanan->status_pesanan);
    $currentProdStatus = strtolower($pesanan->status_produksi);
    $currentShipStatus = $pesanan->pengiriman ? strtolower($pesanan->pengiriman->status_pengiriman) : 'belum_dikirim';

    // 0. Jika status saat ini adalah "Selesai" (selesai)
    if ($currentStatus === 'selesai') {
        return response()->json([
            'success' => false,
            'message' => 'Status pesanan yang sudah Selesai tidak dapat diubah kembali!'
        ], 422);
    }

    // 1. Jika status saat ini adalah "Di Masak" (diproses)
    if ($currentProdStatus === 'diproses') {
        if (in_array($stage, ['menunggu_validasi', 'dikonfirmasi'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak dapat dikembalikan ke status sebelumnya setelah masuk proses memasak (Di Masak).'
            ], 422);
        }
    }

    // 2. Jika status saat ini adalah "Di Kirim" (dikirim)
    if ($currentShipStatus === 'dikirim') {
        if (in_array($stage, ['menunggu_validasi', 'dikonfirmasi', 'di_masak'])) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak dapat dikembalikan ke status sebelumnya setelah pesanan dalam proses pengiriman (Di Kirim).'
            ], 422);
        }
    }

    if ($stage === 'dikonfirmasi') {
        $pesanan->update([
            'status_pesanan' => 'disetujui',
        ]);
    } elseif ($stage === 'di_masak') {
        $pesanan->update([
            'status_pesanan' => 'disetujui',
            'status_produksi' => 'diproses',
        ]);
    } elseif ($stage === 'di_antar') {
        $pesanan->update([
            'status_pesanan' => 'disetujui',
            'status_produksi' => 'selesai',
        ]);
        $pesanan->pengiriman()->updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'alamat_tujuan' => $pesanan->alamat_pengiriman,
                'status_pengiriman' => 'dikirim',
                'waktu_berangkat' => now(),
            ]
        );
    } elseif ($stage === 'selesai') {
        $hasPelunasanPaid = $pesanan->pembayarans
            ? $pesanan->pembayarans->contains(fn($p) => $p->jenis_pembayaran === 'pelunasan' && in_array(strtolower($p->status_bayar), ['diverifikasi', 'lunas', 'settlement', 'success']))
            : false;

        if (!$hasPelunasanPaid) {
            return response()->json([
                'success' => false,
                'message' => 'Status tidak dapat diubah menjadi Selesai karena sisa pelunasan belum dibayar/diverifikasi!'
            ], 422);
        }

        $pesanan->update([
            'status_pesanan' => 'selesai',
            'status_produksi' => 'selesai',
        ]);
        $pesanan->pengiriman()->updateOrCreate(
            ['pesanan_id' => $pesanan->id],
            [
                'alamat_tujuan' => $pesanan->alamat_pengiriman,
                'status_pengiriman' => 'sampai',
                'waktu_tiba' => now(),
            ]
        );
    } elseif ($stage === 'batal') {
        $pesanan->update([
            'status_pesanan' => 'ditolak',
        ]);
    } else { // menunggu_validasi
        $pesanan->update([
            'status_pesanan' => 'menunggu_validasi',
            'status_produksi' => 'belum_diproses',
        ]);
        if ($pesanan->pengiriman) {
            $pesanan->pengiriman->update(['status_pengiriman' => 'belum_dikirim']);
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Status pesanan berhasil diperbarui!',
        'pesanan' => $pesanan->fresh(['pengiriman'])
    ]);
})->middleware(['auth'])->name('penjual.orders.update-status');

Route::get('/penjual/reports', function () {
    $transactions = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])
        ->with(['user', 'pesananPaket.paket', 'pembayarans', 'pengiriman'])
        ->latest('created_at')
        ->paginate(10);

    $totalSalesSum = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])->sum('total_harga');
    $totalOrdersCount = \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])->count();
    $avgOrderValue = $totalOrdersCount > 0 ? round($totalSalesSum / $totalOrdersCount) : 0;

    $popularPaket = \App\Models\Paket::withCount('pesananPaket')->orderBy('pesanan_paket_count', 'desc')->first();
    $popularPaketName = $popularPaket ? $popularPaket->nm_paket : 'Royal Wedding Buffet';

    // Calculate real monthly revenue for the last 6 months
    $monthlyGrowth = [];
    $maxMonthlyRevenue = 0;

    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);
        $monthName = $date->translatedFormat('M');

        $sum = (float) \App\Models\Pesanan::whereNotIn('status_pesanan', ['batal', 'ditolak'])
            ->whereYear('tgl_pesan', $date->year)
            ->whereMonth('tgl_pesan', $date->month)
            ->sum('total_harga');

        if ($sum > $maxMonthlyRevenue) {
            $maxMonthlyRevenue = $sum;
        }

        $monthlyGrowth[] = [
            'month' => strtoupper($monthName),
            'revenue' => $sum,
            'is_current' => ($i === 0),
        ];
    }

    return view('penjual.reports', compact(
        'transactions',
        'totalSalesSum',
        'totalOrdersCount',
        'avgOrderValue',
        'popularPaketName',
        'monthlyGrowth',
        'maxMonthlyRevenue'
    ));
})->middleware(['auth'])->name('penjual.reports');











