<!-- MODAL: LOGIN MODAL FOR GUESTS -->
<div id="loginModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#FDFDF6] rounded-[32px] shadow-2xl border border-stone-200/50 w-full max-w-sm overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col relative p-8">
        <!-- Close Button -->
        <button onclick="closeLoginModal()" class="absolute top-4 right-5 text-gray-400 hover:text-gray-600 text-2xl font-semibold cursor-pointer">&times;</button>
        
        <!-- Header -->
        <div class="text-center mb-6">
            <h3 class="text-2xl font-bold font-serif text-gray-900">Masuk / Daftar</h3>
            <p class="text-xs text-gray-500 font-light mt-1">Silakan masuk untuk melihat pesanan Anda.</p>
        </div>

        <!-- Google OAuth Button -->
        <a href="{{ route('auth.google.redirect') }}" class="w-full flex items-center justify-center gap-3 bg-white hover:bg-stone-50 text-gray-700 font-semibold py-2.5 px-4 rounded-xl border border-gray-200 shadow-xs hover:shadow-md transition-all text-xs cursor-pointer mb-5">
            <!-- Google SVG Icon -->
            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
            </svg>
            <span>Lanjutkan dengan Google</span>
        </a>

        <!-- Divider -->
        <div class="flex items-center justify-center gap-3 mb-5">
            <div class="h-px bg-gray-200 flex-1"></div>
            <span class="text-[11px] text-gray-400 font-light uppercase tracking-wider">atau</span>
            <div class="h-px bg-gray-200 flex-1"></div>
        </div>

        <!-- Regular Login Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="login_email" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                <input type="text" id="login_email" name="login" required placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-xs bg-[#FDFDFC]">
            </div>

            <div>
                <label for="login_password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                <input type="password" id="login_password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-xs bg-[#FDFDFC]">
            </div>

            <button type="submit" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3 rounded-xl transition-all shadow-md text-xs cursor-pointer">
                Masuk
            </button>
        </form>

        <!-- Footer Sign Up Link -->
        <div class="text-center mt-6">
            <p class="text-xs text-gray-500 font-light">
                Belum punya akun? <a href="{{ route('register') }}" class="text-brand-green font-semibold hover:underline">Daftar sekarang.</a>
            </p>
        </div>
    </div>
</div>

<!-- SUCCESS SCREEN OVERLAY -->
<div id="successOverlay" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl p-8 text-center max-w-sm w-full space-y-6">
        <div class="w-16 h-16 rounded-full bg-green-100 text-brand-green flex items-center justify-center text-3xl font-bold mx-auto">
            ✓
        </div>
        <h3 class="text-xl font-bold font-serif text-gray-900">Pemesanan Berhasil!</h3>
        <p id="successMessage" class="text-sm text-gray-500 font-light leading-relaxed">
            Pesanan Anda berhasil dibuat! Tim kami akan segera memvalidasi pesanan Anda dan menghubungi via telepon.
        </p>
        <button onclick="closeSuccessOverlay()" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-semibold py-3 rounded-xl shadow-md cursor-pointer">
            Selesai
        </button>
    </div>
</div>

<!-- MODAL: USER ORDERS HISTORY (My Orders) -->
<div id="ordersModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-stone-200 w-full max-w-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[85vh]">
        <!-- Header -->
        <div class="bg-[#2D5A27] text-white p-6 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold font-serif">Riwayat Pesanan Saya</h3>
                <p class="text-xs text-green-100 font-light mt-1">Daftar transaksi catering yang telah Anda lakukan</p>
            </div>
            <button onclick="closeOrdersModal()" class="text-white/80 hover:text-white text-2xl font-semibold cursor-pointer">&times;</button>
        </div>

        <!-- Body -->
        <div class="p-6 overflow-y-auto flex-1 space-y-4">
            @auth
                @if(isset($myOrders))
                    @forelse($myOrders as $order)
                        <!-- Order Item Card -->
                        <div class="border border-[#E5E5DC] rounded-2xl p-4 bg-cream-card space-y-3">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-[#E5E5DC]/50 pb-3">
                                <div>
                                    <p class="text-xs text-gray-400">ID Pesanan: #{{ $order->id }}</p>
                                    <p class="text-xs text-gray-500 font-medium">Tanggal Acara: <span class="text-gray-800">{{ $order->tgl_acara->format('d M Y') }}</span></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    @php
                                         $statusColors = [
                                             'menunggu_validasi' => 'bg-amber-100 text-amber-800 border-amber-200',
                                             'disetujui' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                             'dikonfirmasi' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                             'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                             'batal' => 'bg-red-100 text-red-700 border-red-200',
                                             'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                         ];
                                         $statusLabel = [
                                             'menunggu_validasi' => 'Menunggu Validasi',
                                             'disetujui' => 'Dikonfirmasi',
                                             'dikonfirmasi' => 'Dikonfirmasi',
                                             'ditolak' => 'Ditolak',
                                             'batal' => 'Dibatalkan',
                                             'selesai' => 'Selesai',
                                         ];
                                         $statusClass = $statusColors[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                         $statusTxt = $statusLabel[$order->status_pesanan] ?? $order->status_pesanan;

                                         $prodStatus = strtolower($order->status_produksi ?? 'belum_diproses');
                                         $shipStatus = $order->pengiriman ? strtolower($order->pengiriman->status_pengiriman) : 'belum_dikirim';
                                    @endphp
                                    <span class="text-[10px] font-bold py-1 px-2.5 rounded-full border {{ $statusClass }}">
                                        {{ $statusTxt }}
                                    </span>

                                    @if($shipStatus === 'dikirim')
                                        <span class="text-[10px] font-bold py-1 px-2.5 rounded-full border bg-purple-100 text-purple-800 border-purple-200">
                                            🚚 Di Antar (Kurir)
                                        </span>
                                    @elseif($prodStatus === 'diproses')
                                        <span class="text-[10px] font-bold py-1 px-2.5 rounded-full border bg-indigo-100 text-indigo-800 border-indigo-200">
                                            🍳 Di Masak (Dapur)
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="space-y-1.5">
                                @foreach($order->pesananPaket as $item)
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="font-bold text-gray-700">{{ $item->paket->nm_paket }}</span>
                                        <span class="text-gray-500">{{ $item->jml_paket }} Porsi</span>
                                    </div>
                                    <div class="pl-3 text-[11px] text-gray-400 leading-relaxed font-light">
                                        Lauk: {{ $item->lauks->map(fn($l) => $l->lauk->nama_lauk)->implode(', ') }}
                                    </div>
                                @endforeach

                                @if($order->gubukan)
                                    <div class="flex justify-between items-center text-xs pt-1.5 border-t border-dashed border-[#E5E5DC]/80">
                                        <span class="text-gray-600">Stall: {{ $order->gubukan->nama_gubukan }}</span>
                                        <span class="text-gray-500">1 unit</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-[#E5E5DC]/50 bg-white/40 -mx-4 -mb-4 p-4 rounded-b-2xl">
                                <div>
                                    <p class="text-[10px] text-gray-400 font-light">Total Pembayaran</p>
                                    <p class="text-sm font-extrabold text-brand-green">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</p>
                                </div>

                                @php
                                    $pembayaranTerakhir = $order->pembayarans->last();
                                    $statusBayar = $pembayaranTerakhir ? strtolower($pembayaranTerakhir->status_bayar) : 'belum_bayar';
                                    
                                    $bayarLabels = [
                                        'belum_bayar' => 'Belum Dibayar',
                                        'pending' => 'Menunggu Pembayaran',
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'diverifikasi' => 'Terverifikasi (DP)',
                                        'lunas' => 'Lunas',
                                        'gagal' => 'Gagal Pembayaran',
                                        'ditolak' => 'Pembayaran Ditolak',
                                    ];
                                    $bayarColors = [
                                        'belum_bayar' => 'bg-red-50 text-red-600 border-red-200',
                                        'pending' => 'bg-orange-50 text-orange-600 border-orange-200',
                                        'menunggu_verifikasi' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                                        'diverifikasi' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        'lunas' => 'bg-green-50 text-green-700 border-green-200',
                                        'gagal' => 'bg-rose-50 text-rose-700 border-rose-200',
                                        'ditolak' => 'bg-red-100 text-red-700 border-red-300',
                                    ];

                                    $labelBayar = $bayarLabels[$statusBayar] ?? ucfirst(str_replace('_', ' ', $statusBayar));
                                    $colorBayar = $bayarColors[$statusBayar] ?? 'bg-gray-50 text-gray-700 border-gray-200';
                                @endphp
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold px-2 py-1 rounded border {{ $colorBayar }}">
                                        💳 {{ $labelBayar }}
                                    </span>
                                    
                                    @if($statusBayar === 'belum_bayar' && $order->status_pesanan === 'disetujui')
                                        <button onclick="payOrder({{ $order->id }}, {{ $order->total_harga }})" class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold py-1.5 px-3.5 rounded-lg shadow transition-colors cursor-pointer">
                                            Bayar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12 space-y-3">
                            <span class="text-4xl block">📦</span>
                            <p class="text-sm text-gray-500 font-light">Anda belum memiliki riwayat pemesanan catering.</p>
                        </div>
                    @endforelse
                @endif
            @else
                <div class="text-center py-12">
                    <p class="text-sm text-gray-500">Silakan login untuk melihat riwayat pesanan.</p>
                </div>
            @endauth
        </div>
    </div>
</div>

<!-- WARNING/ALERT MODAL FOR LAUK LIMIT -->
<div id="laukLimitModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-[#FDFDF6] rounded-[32px] shadow-2xl border border-stone-200/50 w-full max-w-sm overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col relative p-8 text-center space-y-6">
        <!-- Close Button (Icon) -->
        <button onclick="closeLaukLimitModal()" class="absolute top-4 right-5 text-gray-400 hover:text-gray-600 text-2xl font-semibold cursor-pointer">&times;</button>
        
        <!-- Warning Icon -->
        <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-3xl font-bold mx-auto">
            ⚠️
        </div>
        
        <!-- Title and Message -->
        <div class="space-y-2">
            <h3 class="text-xl font-bold font-serif text-gray-900">Batas Maksimal Lauk</h3>
            <p id="laukLimitMessage" class="text-xs text-gray-500 font-light leading-relaxed">
                Anda hanya boleh memilih maksimal 3 lauk untuk paket ini.
            </p>
        </div>
        
        <!-- Action Button -->
        <button onclick="closeLaukLimitModal()" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-xl shadow-md transition-all text-xs uppercase tracking-wider cursor-pointer">
            Mengerti
        </button>
    </div>
</div>

<script>
    function openLaukLimitModal(limit) {
        const modal = document.getElementById('laukLimitModal');
        if (!modal) return;
        const msg = document.getElementById('laukLimitMessage');
        if (msg) {
            msg.textContent = `Anda hanya boleh memilih maksimal ${limit} lauk untuk paket ini.`;
        }
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
        }, 10);
    }

    function closeLaukLimitModal() {
        const modal = document.getElementById('laukLimitModal');
        if (!modal) return;
        modal.firstElementChild.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>

