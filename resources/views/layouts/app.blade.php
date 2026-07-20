<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'RASACI Catering')</title>

        <!-- Meta Description for SEO -->
        <meta name="description" content="@yield('meta-description', 'RASACI Catering menghadirkan layanan catering bintang lima dengan cita rasa Nusantara autentik untuk pesta pernikahan, rapat kantor, syukuran, dan acara spesial Anda.')">

        <!-- Google Fonts: Playfair Display (Serif) & Plus Jakarta Sans (Sans-serif) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F8F8F2; /* Cream/off-white background */
            }
            .font-serif {
                font-family: 'Playfair Display', Georgia, serif;
            }
            .text-brand-green {
                color: #2D5A27;
            }
            .bg-brand-green {
                background-color: #2D5A27;
            }
            .bg-brand-green-hover:hover {
                background-color: #21441D;
            }
            .border-brand-green {
                border-color: #2D5A27;
            }
            .bg-cream-card {
                background-color: #FDFDF6;
            }
            .ambient-shadow {
                box-shadow: 0 10px 25px -5px rgba(45, 90, 39, 0.05);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in {
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            .delay-200 {
                animation-delay: 0.2s;
            }
            .delay-400 {
                animation-delay: 0.4s;
            }
        </style>

        @yield('styles')
    </head>
    <body class="antialiased text-[#1b1b18] min-h-screen flex flex-col">

        <!-- HEADER / NAVBAR -->
        <header class="sticky top-0 z-40 w-full bg-[#F8F8F2]/90 backdrop-blur-md border-b border-[#E5E5DC] py-4 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <span class="text-2xl font-bold tracking-widest font-serif text-brand-green">RASACI</span>
                    </a>
                </div>

                <!-- Navigation Links (Desktop) -->
                <nav class="hidden md:flex space-x-8 text-sm font-medium">
                    <a href="/#packages" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">Packages</a>
                    <a href="/#how-it-works" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">How It Works</a>
                    <a href="/#reviews" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">Reviews</a>
                </nav>

                <!-- Auth Buttons & Actions -->
                <div class="flex items-center space-x-4">
                    @auth
                        <button onclick="openOrdersModal()" class="text-gray-600 hover:text-brand-green text-sm font-medium transition-colors flex items-center gap-1 cursor-pointer">
                            <!-- Shopping Bag Icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                            </svg>
                            My Orders
                            @if($myOrders->count() > 0)
                                <span class="bg-brand-green text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $myOrders->count() }}</span>
                            @endif
                        </button>
                        
                        <div class="h-4 w-px bg-gray-300 hidden sm:block"></div>

                        <span class="text-gray-700 text-sm hidden sm:inline font-medium">Hai, <span class="text-brand-green">{{ Auth::user()->name }}</span></span>

                        @if(Auth::user()->isPenjual())
                            <a href="/penjual/dashboard" class="text-xs bg-amber-500 hover:bg-amber-600 text-white font-medium py-1.5 px-3 rounded-md transition-all shadow-sm">Dashboard</a>
                        @endif

                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-medium py-1.5 px-3 rounded-md border border-red-200 hover:bg-red-50 transition-all cursor-pointer">
                                Sign Out
                            </button>
                        </form>
                    @else
                        <button onclick="openLoginModal()" class="text-gray-600 hover:text-brand-green text-sm font-medium transition-colors cursor-pointer">
                            My Orders
                        </button>
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-brand-green bg-brand-green-hover text-white text-sm font-medium px-5 py-2 rounded-lg transition-all shadow-md">
                            Sign In
                        </a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- PAGE CONTENT -->
        @yield('content')

        <!-- FOOTER -->
        <footer class="bg-[#ECECE6] pt-16 pb-8 border-t border-[#E5E5DC]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-4 gap-8 text-sm mb-12">
                <!-- Col 1: Brand Info -->
                <div class="space-y-4">
                    <span class="text-xl font-bold font-serif text-brand-green tracking-widest">RASACI</span>
                    <p class="text-gray-500 font-light leading-relaxed">
                        Menghadirkan kelezatan autentik di setiap momen berharga Anda sejak 2015.
                    </p>
                    <div class="flex space-x-3 text-gray-400">
                        <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm shadow-sm hover:text-brand-green cursor-pointer">🌐</span>
                        <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm shadow-sm hover:text-brand-green cursor-pointer">📸</span>
                        <span class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-sm shadow-sm hover:text-brand-green cursor-pointer">📍</span>
                    </div>
                </div>

                <!-- Col 2: Quick Links -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 font-serif">Tautan Cepat</h4>
                    <ul class="space-y-2 font-light text-gray-600">
                        <li><a href="#" class="hover:text-brand-green transition-colors">About Us</a></li>
                        <li><a href="/#packages" class="hover:text-brand-green transition-colors">Packages</a></li>
                        <li><a href="/#how-it-works" class="hover:text-brand-green transition-colors">How It Works</a></li>
                        <li><a href="/#reviews" class="hover:text-brand-green transition-colors">Reviews</a></li>
                    </ul>
                </div>

                <!-- Col 3: Support -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 font-serif">Bantuan</h4>
                    <ul class="space-y-2 font-light text-gray-600">
                        <li><a href="https://wa.me/6281234567890" class="hover:text-brand-green transition-colors">Contact</a></li>
                        <li><a href="#" class="hover:text-brand-green transition-colors">Privacy Policy</a></li>
                        <li><a href="#" class="hover:text-brand-green transition-colors">Terms of Service</a></li>
                        <li><a href="#" class="hover:text-brand-green transition-colors">FAQ</a></li>
                    </ul>
                </div>

                <!-- Col 4: Contact info -->
                <div>
                    <h4 class="font-bold text-gray-900 mb-4 font-serif">Hubungi Kami</h4>
                    <ul class="space-y-3 font-light text-gray-600">
                        <li class="flex items-start gap-2">
                            <span class="shrink-0 mt-0.5">📍</span>
                            <span>Jl. Raya Senopati No. 45, Jakarta Selatan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="shrink-0 mt-0.5">📞</span>
                            <span>+62 812-3456-7890</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="shrink-0 mt-0.5">✉️</span>
                            <span>halo@rasaci.com</span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 border-t border-[#D5D5CC] pt-8 text-center text-xs text-gray-400 font-light">
                &copy; {{ date('Y') }} RASACI Catering. All rights reserved.
            </div>
        </footer>

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

                <!-- Google OAuth Button (Mock) -->
                <button onclick="mockGoogleLogin()" class="w-full flex items-center justify-center gap-3 bg-white hover:bg-gray-50 text-gray-700 font-semibold py-2.5 px-4 rounded-xl border border-gray-200 shadow-sm transition-all text-xs cursor-pointer mb-5">
                    <!-- Google SVG Icon -->
                    <svg class="w-4 h-4" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                    </svg>
                    <span>Lanjutkan dengan Google</span>
                </button>

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

                    <button type="submit" class="w-full bg-brand-green bg-brand-green-hover text-white font-bold py-3 rounded-xl transition-all shadow-md text-xs cursor-pointer">
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
                <button onclick="closeSuccessOverlay()" class="w-full bg-brand-green bg-brand-green-hover text-white font-semibold py-3 rounded-xl shadow-md cursor-pointer">
                    Selesai
                </button>
            </div>
        </div>

        <!-- MODAL: USER ORDERS HISTORY (My Orders) -->
        <div id="ordersModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl border border-stone-200 w-full max-w-2xl overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[85vh]">
                <!-- Header -->
                <div class="bg-brand-green text-white p-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold font-serif">Riwayat Pesanan Saya</h3>
                        <p class="text-xs text-green-100 font-light mt-1">Daftar transaksi catering yang telah Anda lakukan</p>
                    </div>
                    <button onclick="closeOrdersModal()" class="text-white/80 hover:text-white text-2xl font-semibold cursor-pointer">&times;</button>
                </div>

                <!-- Body -->
                <div class="p-6 overflow-y-auto flex-1 space-y-4">
                    @auth
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
                                                'menunggu_validasi' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                'disetujui' => 'bg-blue-100 text-blue-700 border-blue-200',
                                                'ditolak' => 'bg-red-100 text-red-700 border-red-200',
                                                'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                            ];
                                            $statusLabel = [
                                                'menunggu_validasi' => 'Menunggu Validasi',
                                                'disetujui' => 'Disetujui',
                                                'ditolak' => 'Ditolak',
                                                'selesai' => 'Selesai',
                                            ];
                                            $statusClass = $statusColors[$order->status_pesanan] ?? 'bg-gray-100 text-gray-700 border-gray-200';
                                            $statusTxt = $statusLabel[$order->status_pesanan] ?? $order->status_pesanan;
                                        @endphp
                                        <span class="text-[10px] font-bold py-1 px-2.5 rounded-full border {{ $statusClass }}">
                                            {{ $statusTxt }}
                                        </span>

                                        @php
                                            $prodColors = [
                                                'belum_diproses' => 'bg-stone-100 text-stone-600 border-stone-200',
                                                'sedang_dimasak' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                                                'siap_diantar' => 'bg-amber-100 text-amber-700 border-amber-200',
                                                'selesai' => 'bg-green-100 text-green-700 border-green-200',
                                            ];
                                            $prodLabel = [
                                                'belum_diproses' => 'Belum Diproses',
                                                'sedang_dimasak' => 'Sedang Dimasak',
                                                'siap_diantar' => 'Siap Diantar',
                                                'selesai' => 'Pengiriman Selesai',
                                            ];
                                            $prodClass = $prodColors[$order->status_produksi] ?? 'bg-gray-100 text-gray-600 border-gray-200';
                                            $prodTxt = $prodLabel[$order->status_produksi] ?? $order->status_produksi;
                                        @endphp
                                        @if($order->status_pesanan === 'disetujui' || $order->status_pesanan === 'selesai')
                                            <span class="text-[10px] font-bold py-1 px-2.5 rounded-full border {{ $prodClass }}">
                                                🍳 {{ $prodTxt }}
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
                                        $statusBayar = $pembayaranTerakhir ? $pembayaranTerakhir->status_bayar : 'belum_bayar';
                                        
                                        $bayarLabels = [
                                            'belum_bayar' => 'Belum Dibayar',
                                            'pending' => 'Menunggu Pembayaran',
                                            'lunas' => 'Lunas',
                                            'gagal' => 'Gagal',
                                        ];
                                        $bayarColors = [
                                            'belum_bayar' => 'bg-red-50 text-red-600 border-red-200',
                                            'pending' => 'bg-orange-50 text-orange-600 border-orange-200',
                                            'lunas' => 'bg-green-50 text-green-600 border-green-200',
                                            'gagal' => 'bg-red-100 text-red-700 border-red-300',
                                        ];
                                    @endphp
                                    <div class="flex items-center gap-2">
                                        <span class="text-[10px] font-bold px-2 py-1 rounded border {{ $bayarColors[$statusBayar] }}">
                                            💳 {{ $bayarLabels[$statusBayar] }}
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
                    @else
                        <div class="text-center py-12">
                            <p class="text-sm text-gray-500">Silakan login untuk melihat riwayat pesanan.</p>
                        </div>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Page-specific modals -->
        @yield('modals')

        <!-- SHARED JAVASCRIPT -->
        <script>
            // OPEN & CLOSE LOGIN MODAL FOR GUESTS
            function openLoginModal() {
                const modal = document.getElementById('loginModal');
                if (!modal) return;
                
                const emailInput = document.getElementById('login_email');
                const passwordInput = document.getElementById('login_password');
                if (emailInput) emailInput.value = '';
                if (passwordInput) passwordInput.value = '';
                
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }

            function closeLoginModal() {
                const modal = document.getElementById('loginModal');
                if (!modal) return;
                modal.firstElementChild.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            function mockGoogleLogin() {
                alert("[GOOGLE LOGIN] Menghubungkan ke Google Account...\nBerhasil masuk sebagai Budi Santoso!");
                
                const payload = {
                    login: 'budi@example.test',
                    password: 'password'
                };
                
                fetch('{{ route("login") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert("Gagal melakukan login otomatis. Silakan coba login manual.");
                    }
                })
                .catch(error => {
                    alert("Koneksi bermasalah: " + error.message);
                });
            }

            function closeSuccessOverlay() {
                const overlay = document.getElementById('successOverlay');
                if (overlay) {
                    overlay.classList.add('hidden');
                }
                window.location.reload();
            }

            // OPEN & CLOSE ORDERS HISTORIES MODAL (My Orders)
            function openOrdersModal() {
                const modal = document.getElementById('ordersModal');
                if (!modal) return;
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }

            function closeOrdersModal() {
                const modal = document.getElementById('ordersModal');
                if (!modal) return;
                modal.firstElementChild.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // PAY WITH MIDTRANS SNAP (Mock/Real Snap Token execution)
            function payOrder(pesananId, totalHarga) {
                const btn = event.target;
                const originalText = btn.innerText;
                btn.disabled = true;
                btn.innerText = 'Loading...';

                fetch(`/api/pesanan/${pesananId}/bayar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        jumlah_bayar: totalHarga
                    })
                })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal membuat invoice.');
                        }
                        return data;
                    });
                })
                .then(data => {
                    if (window.snap) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pembayaran berhasil!");
                                window.location.reload();
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran Anda.");
                                window.location.reload();
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                window.location.reload();
                            },
                            onClose: function() {
                                alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                                window.location.reload();
                            }
                        });
                    } else {
                        alert(`[MOCK MIDTRANS] Snap Token: ${data.snap_token}. Pembayaran sukses untuk pesanan #${pesananId}`);
                        
                        fetch('/api/webhook/midtrans', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                order_id: pesananId,
                                transaction_status: 'settlement'
                            })
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    alert(error.message);
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerText = originalText;
                });
            }
        </script>

        <!-- Page-specific scripts -->
        @yield('scripts')

        <!-- Inject Midtrans Snap JS for real transactions if needed -->
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    </body>
</html>
