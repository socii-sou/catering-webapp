<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Rasaci Catering - Hidangan Lezat untuk Momen Spesial Anda</title>

        <!-- Meta Description for SEO -->
        <meta name="description" content="Rasaci Catering menghadirkan layanan catering bintang lima dengan cita rasa Nusantara autentik untuk pesta pernikahan, rapat kantor, syukuran, dan acara spesial Anda.">

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
        </style>
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
                    <a href="#packages" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">Packages</a>
                    <a href="#how-it-works" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">How It Works</a>
                    <a href="#reviews" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">Reviews</a>
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

        <!-- HERO SECTION -->
        <section class="relative w-full h-[620px] bg-cover bg-center flex items-center" style="background-image: linear-gradient(to right, rgba(0, 0, 0, 0.7) 35%, rgba(0, 0, 0, 0.4) 100%), url('{{ asset('images/hero_banner.jpg') }}');">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full z-10">
                <div class="max-w-2xl text-white">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold font-serif leading-tight mb-4 opacity-0 translate-y-4 animate-fade-in">
                        Hidangan Lezat untuk Momen Spesial Anda
                    </h1>
                    <p class="text-base sm:text-lg text-gray-200 mb-8 max-w-xl font-light leading-relaxed opacity-0 translate-y-4 animate-fade-in delay-200">
                        Nikmati layanan catering bintang lima dengan bahan-bahan terbaik dan koki profesional untuk setiap perayaan berharga Anda.
                    </p>
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-4 opacity-0 translate-y-4 animate-fade-in delay-400">
                        <a href="#packages" class="inline-flex items-center justify-center bg-brand-green bg-brand-green-hover text-white font-medium px-8 py-3.5 rounded-lg transition-all shadow-lg hover:shadow-xl text-center group">
                            Lihat Paket
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5 ml-2 transform group-hover:translate-x-1 transition-transform">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a href="https://wa.me/6281234567890?text=Halo%20Rasaci%20Catering,%20saya%20ingin%20berkonsultasi%20mengenai%20layanan%20catering." target="_blank" class="inline-flex items-center justify-center bg-white/10 hover:bg-white/20 text-white border border-white/30 backdrop-blur-sm font-medium px-8 py-3.5 rounded-lg transition-all text-center">
                            Konsultasi Gratis
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- WHY US SECTION -->
        <section class="py-20 bg-[#F8F8F2]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-xs font-semibold tracking-widest text-brand-green uppercase block mb-2">Pilihan Terbaik</span>
                <h2 class="text-3xl sm:text-4xl font-bold font-serif mb-12 text-gray-900">Mengapa Memilih Rasaci?</h2>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1: Fresh ingredients -->
                    <div class="bg-cream-card rounded-2xl p-8 border border-[#E5E5DC] text-left hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-full bg-amber-100 flex items-center justify-center text-amber-600 mb-6 text-xl">
                            🌿
                        </div>
                        <h3 class="text-lg font-bold font-serif mb-3 text-gray-900">Fresh ingredients</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-light">
                            Kami hanya menggunakan bahan baku segar terbaik dari petani lokal untuk menjamin kualitas rasa di setiap suapan hidangan kami.
                        </p>
                    </div>

                    <!-- Feature 2: Professional service -->
                    <div class="bg-cream-card rounded-2xl p-8 border border-[#E5E5DC] text-left hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-green-700 mb-6 text-xl">
                            👨‍🍳
                        </div>
                        <h3 class="text-lg font-bold font-serif mb-3 text-gray-900">Professional service</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-light">
                            Koki & pelayan berpengalaman akan menangani berbagai skala acara Anda dengan profesionalisme tinggi dan kebersihan mutlak.
                        </p>
                    </div>

                    <!-- Feature 3: On time delivery -->
                    <div class="bg-cream-card rounded-2xl p-8 border border-[#E5E5DC] text-left hover:shadow-md transition-shadow">
                        <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-orange-600 mb-6 text-xl">
                            ⏱️
                        </div>
                        <h3 class="text-lg font-bold font-serif mb-3 text-gray-900">On time delivery</h3>
                        <p class="text-sm text-gray-600 leading-relaxed font-light">
                            Ketepatan waktu adalah prioritas kami agar momen spesial Anda berjalan sempurna tanpa hambatan logistik makanan.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <!-- PACKAGES SECTION -->
        <section id="packages" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
                    <div>
                        <span class="text-xs font-semibold tracking-widest text-brand-green uppercase block mb-2">Paket Pilihan</span>
                        <h2 class="text-3xl sm:text-4xl font-bold font-serif text-gray-900">Pilih Paket yang Sesuai dengan Kebutuhan Acara Anda</h2>
                    </div>
                    <a href="#packages" class="text-sm font-semibold text-brand-green hover:underline mt-4 sm:mt-0 inline-flex items-center gap-1">
                        Lihat Semua Paket
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @forelse($pakets as $index => $paket)
                        @php
                            // Mapping default images to simulate Nasi Kotak, Prasmanan, and Tumpeng visually
                            $images = [
                                asset('images/nasi_kotak.jpg'), // Nasi Kotak
                                asset('images/prasmanan.jpg'),  // Prasmanan
                                asset('images/tumpeng.jpg'),    // Tumpeng
                            ];
                            $imageUrl = $images[$index % count($images)];
                        @endphp
                        
                        <!-- Package Card -->
                        <div class="bg-cream-card rounded-3xl border border-[#E5E5DC] overflow-hidden flex flex-col justify-between hover:shadow-lg transition-all group">
                            <div>
                                <!-- Image with zoom effect on card hover -->
                                <div class="h-64 overflow-hidden relative">
                                    <img src="{{ $imageUrl }}" alt="{{ $paket->nm_paket }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    <span class="absolute top-4 right-4 bg-brand-green text-white text-xs font-semibold py-1.5 px-3.5 rounded-full shadow-md">
                                        Pilih {{ $paket->jumlah_lauk_pilihan }} Lauk
                                    </span>
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold font-serif mb-2 text-gray-900">{{ $paket->nm_paket }}</h3>
                                    <p class="text-xs text-gray-400 mb-3 tracking-wider uppercase font-semibold">Catering Premium</p>
                                    <p class="text-sm text-gray-600 mb-6 font-light leading-relaxed">
                                        {{ $paket->deskripsi ?? 'Nikmati kelezatan paket pilihan kami dengan standar rasa terjamin untuk kepuasan tamu Anda.' }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-6 pt-0 border-t border-[#E5E5DC]/50 flex items-center justify-between bg-[#FDFDF6]/60">
                                <div>
                                    <p class="text-xs text-gray-500 font-light">Mulai dari</p>
                                    <p class="text-lg font-extrabold text-brand-green">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">/ pax</span></p>
                                </div>
                                <!-- Green Action Arrow Button -->
                                <button onclick="openBookingModal({{ $paket->id }}, '{{ $paket->nm_paket }}', {{ $paket->harga_paket }}, {{ $paket->jumlah_lauk_pilihan }})" class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green hover:bg-brand-green hover:text-white flex items-center justify-center transition-all cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @empty
                        <!-- Fallback Cards matching the UI perfectly if db empty -->
                        <div class="col-span-3 text-center py-8">
                            <p class="text-gray-500 text-sm italic">Belum ada paket aktif. Menampilkan contoh visual:</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- HOW IT WORKS SECTION -->
        <section id="how-it-works" class="py-20 bg-[#F8F8F2] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    
                    <!-- Left Column: Premium CSS Phone Mockup -->
                    <div class="relative flex justify-center lg:justify-start">
                        <!-- Decorative background blobs -->
                        <div class="absolute -top-12 -left-12 w-64 h-64 bg-green-200/50 rounded-full filter blur-2xl"></div>
                        <div class="absolute -bottom-12 -right-12 w-64 h-64 bg-amber-100/60 rounded-full filter blur-2xl"></div>
                        
                        <!-- Phone Mockup Container -->
                        <div class="relative w-[280px] h-[560px] bg-stone-900 rounded-[45px] p-3 shadow-2xl border-4 border-stone-800 flex-shrink-0 z-10">
                            <!-- Notch/Dynamic Island -->
                            <div class="absolute top-4 left-1/2 transform -translate-x-1/2 w-28 h-6 bg-black rounded-full z-30"></div>
                            
                            <!-- Phone Screen -->
                            <div class="w-full h-full bg-[#FDFDFC] rounded-[36px] overflow-hidden border border-stone-950 flex flex-col relative z-20">
                                <!-- App Header -->
                                <div class="bg-brand-green px-4 pt-8 pb-4 text-white flex items-center justify-between">
                                    <span class="text-xs font-serif font-semibold tracking-wider">RASACI APP</span>
                                    <span class="text-[9px] bg-white/20 px-2 py-0.5 rounded-full text-white/95">Pesan Online</span>
                                </div>
                                <!-- App Content List -->
                                <div class="flex-1 p-4 space-y-3 overflow-y-auto bg-[#F8F8F2]/50">
                                    <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Catering Hari Ini</div>
                                    
                                    <!-- Mock Card 1 -->
                                    <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-2">
                                        <div class="w-10 h-10 rounded-lg bg-cover bg-center shrink-0" style="background-image: url('https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=100');"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[11px] font-bold text-gray-800 truncate">Nasi Kotak Nusantara</p>
                                            <p class="text-[9px] text-gray-500">Pilih 3 Lauk Pilihan</p>
                                        </div>
                                        <span class="text-[9px] font-extrabold text-brand-green shrink-0">Rp 35k</span>
                                    </div>

                                    <!-- Mock Card 2 -->
                                    <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center space-x-2">
                                        <div class="w-10 h-10 rounded-lg bg-cover bg-center shrink-0" style="background-image: url('https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=100');"></div>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-[11px] font-bold text-gray-800 truncate">Prasmanan Spesial</p>
                                            <p class="text-[9px] text-gray-500">Pilih 5 Lauk Pilihan</p>
                                        </div>
                                        <span class="text-[9px] font-extrabold text-brand-green shrink-0">Rp 50k</span>
                                    </div>

                                    <!-- Selected Lauk Counter Badge mockup -->
                                    <div class="border border-dashed border-brand-green/30 rounded-xl p-3 bg-brand-green/5 space-y-1.5">
                                        <div class="flex justify-between items-center text-[10px]">
                                            <span class="font-bold text-brand-green">Pilihan Lauk (3/3)</span>
                                            <span class="text-[9px] text-gray-400">Terpilih</span>
                                        </div>
                                        <div class="flex flex-wrap gap-1">
                                            <span class="text-[8px] bg-brand-green text-white px-2 py-0.5 rounded-full">Rendang Sapi</span>
                                            <span class="text-[8px] bg-brand-green text-white px-2 py-0.5 rounded-full">Ayam Bakar</span>
                                            <span class="text-[8px] bg-brand-green text-white px-2 py-0.5 rounded-full">Telur Balado</span>
                                        </div>
                                    </div>

                                    <!-- Price summary mock -->
                                    <div class="bg-white p-3 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between text-[11px]">
                                        <span class="text-gray-500">Total Pembayaran</span>
                                        <span class="font-bold text-brand-green">Rp 1.750.000</span>
                                    </div>
                                </div>
                                <!-- App Footer Action -->
                                <div class="p-3 bg-white border-t border-gray-100">
                                    <div class="w-full bg-brand-green py-2 rounded-xl text-center text-white text-[11px] font-bold shadow-sm">
                                        Pesan Sekarang
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column: Process Steps -->
                    <div>
                        <span class="text-xs font-semibold tracking-widest text-brand-green uppercase block mb-2">Proses Kami</span>
                        <h2 class="text-3xl sm:text-4xl font-bold font-serif mb-8 text-gray-900">Senudah Beberapa Klik</h2>

                        <div class="space-y-6">
                            <!-- Step 1 -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                                    1
                                </div>
                                <div>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Choose</h3>
                                    <p class="text-sm text-gray-600 font-light leading-relaxed">
                                        Pilih paket catering yang paling sesuai dengan kebutuhan jumlah tamu dan jenis acara Anda.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 2 -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                                    2
                                </div>
                                <div>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Order</h3>
                                    <p class="text-sm text-gray-600 font-light leading-relaxed">
                                        Tentukan menu lauk pauk pilihan, jumlah porsi, tanggal acara, serta tambahan gubukan jika diperlukan.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 3 -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                                    3
                                </div>
                                <div>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Payment</h3>
                                    <p class="text-sm text-gray-600 font-light leading-relaxed">
                                        Lakukan konfirmasi pemesanan dan pembayaran dengan metode transfer online secara aman.
                                    </p>
                                </div>
                            </div>

                            <!-- Step 4 -->
                            <div class="flex items-start space-x-4">
                                <div class="w-10 h-10 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center font-bold text-sm shrink-0 mt-0.5">
                                    4
                                </div>
                                <div>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Enjoy</h3>
                                    <p class="text-sm text-gray-600 font-light leading-relaxed">
                                        Duduk santai dengan tenang, kami akan mengantarkan hidangan lezat dan menyajikannya secara prima bagi para tamu Anda.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- REVIEWS SECTION -->
        <section id="reviews" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-xs font-semibold tracking-widest text-brand-green uppercase block mb-2">Testimoni</span>
                    <h2 class="text-3xl sm:text-4xl font-bold font-serif text-gray-900">Apa Kata Mereka?</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    @forelse($reviews as $review)
                        <!-- Review Card -->
                        <div class="bg-cream-card rounded-2xl p-8 border border-[#E5E5DC] flex flex-col justify-between hover:shadow-sm transition-shadow">
                            <div>
                                <!-- Rating Stars -->
                                <div class="flex text-amber-500 mb-4">
                                    @for($i = 0; $i < 5; $i++)
                                        @if($i < $review->rating)
                                            <!-- Solid Star -->
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                            </svg>
                                        @else
                                            <!-- Outline Star -->
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.174-.29.641-.29.815 0l2.88 4.906 5.568.397c.328.023.458.423.208.638l-4.167 3.58 1.25 5.372c.074.316-.271.567-.534.397L12 15.654l-4.702 2.848c-.263.17-.608-.081-.534-.397l1.25-5.372-4.167-3.58c-.25-.215-.12-.615.208-.638l5.568-.397 2.88-4.906Z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                                <blockquote class="text-gray-700 italic text-sm leading-relaxed mb-6 font-light">
                                    "{{ $review->ulasan }}"
                                </blockquote>
                            </div>
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full bg-brand-green/20 text-brand-green flex items-center justify-center font-bold text-sm shrink-0">
                                    {{ strtoupper(substr($review->user->name, 0, 2)) }}
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                                    <p class="text-xs text-gray-500 font-light">
                                        {{ $review->user->email === 'anita@example.test' ? 'Ibu Rumah Tangga' : ($review->user->email === 'budi@example.test' ? 'Manager IT' : 'Pelanggan Terverifikasi') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-2 text-center py-8">
                            <p class="text-gray-500 text-sm italic">Belum ada review dari pelanggan.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

        <!-- CTA SECTION (Subscription Banner) -->
        <section class="py-12 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-brand-green rounded-3xl p-8 sm:p-12 lg:p-16 text-white text-center shadow-xl relative overflow-hidden">
                    <!-- Overlay shapes -->
                    <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/5 rounded-full"></div>
                    <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-white/5 rounded-full"></div>
                    
                    <div class="relative z-10 max-w-2xl mx-auto">
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-serif mb-4">Siap untuk Acara yang Berkesan?</h2>
                        <p class="text-sm text-green-100 mb-8 font-light">
                            Konsultasikan kebutuhan catering Anda sekarang dan dapatkan penawaran khusus untuk pemesanan pertama.
                        </p>
                        
                        <form onsubmit="event.preventDefault(); alert('Terima kasih! Anda telah terdaftar dalam newsletter kami.'); this.reset();" class="flex flex-col sm:flex-row items-stretch gap-3 max-w-md mx-auto">
                            <input type="email" placeholder="Alamat Email Anda" required class="flex-1 px-4 py-3 rounded-lg bg-white/10 text-white placeholder-green-200 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/40 text-sm">
                            <button type="submit" class="bg-white text-brand-green hover:bg-green-50 font-bold px-6 py-3 rounded-lg transition-colors text-sm shadow-sm cursor-pointer">
                                Mulai Berlangganan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </section>

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
                        <li><a href="#packages" class="hover:text-brand-green transition-colors">Packages</a></li>
                        <li><a href="#how-it-works" class="hover:text-brand-green transition-colors">How It Works</a></li>
                        <li><a href="#reviews" class="hover:text-brand-green transition-colors">Reviews</a></li>
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

        <!-- MODAL 0: SIMPLE LOGIN MODAL FOR GUESTS -->
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
                    <!-- Email field -->
                    <div>
                        <label for="login_email" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Email</label>
                        <input type="text" id="login_email" name="login" required placeholder="nama@email.com" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-xs bg-[#FDFDFC]">
                    </div>

                    <!-- Password field -->
                    <div>
                        <label for="login_password" class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1.5">Kata Sandi</label>
                        <input type="password" id="login_password" name="password" required placeholder="••••••••" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-xs bg-[#FDFDFC]">
                    </div>

                    <!-- Submit Button -->
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

        <!-- MODAL 1: INTERACTIVE BOOKING MODAL -->
        <div id="bookingModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl border border-stone-200 w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
                <!-- Modal Header -->
                <div class="bg-brand-green text-white p-6 flex justify-between items-center">
                    <div>
                        <h3 id="modalTitle" class="text-xl font-bold font-serif">Pilih Paket</h3>
                        <p class="text-xs text-green-100 font-light mt-1">Lengkapi formulir pemesanan catering di bawah ini</p>
                    </div>
                    <button onclick="closeBookingModal()" class="text-white/80 hover:text-white text-2xl font-semibold cursor-pointer">&times;</button>
                </div>

                <!-- Modal Body (Scrollable) -->
                <div class="p-6 overflow-y-auto flex-1 space-y-6">
                    @guest
                        <!-- Login Redirect Panel -->
                        <div class="text-center py-8 space-y-4">
                            <span class="text-5xl block">🔒</span>
                            <h4 class="text-lg font-bold text-gray-900 font-serif">Autentikasi Diperlukan</h4>
                            <p class="text-sm text-gray-500 max-w-sm mx-auto font-light leading-relaxed">
                                Silakan masuk ke akun Anda terlebih dahulu untuk dapat melakukan pemesanan paket catering secara online.
                            </p>
                            <div class="flex items-center justify-center gap-3 pt-4">
                                <a href="{{ route('login') }}" class="bg-brand-green bg-brand-green-hover text-white text-sm font-semibold px-6 py-2.5 rounded-lg shadow-md">
                                    Sign In
                                </a>
                                <a href="{{ route('register') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-semibold px-6 py-2.5 rounded-lg border border-gray-200">
                                    Daftar Akun
                                </a>
                            </div>
                        </div>
                    @else
                        <!-- Order Form -->
                        <form id="orderForm" onsubmit="submitOrder(event)" class="space-y-5">
                            @csrf
                            <!-- Hidden inputs for package -->
                            <input type="hidden" name="items[0][paket_id]" id="inputPaketId">
                            <input type="hidden" name="items[0][jml_paket]" id="inputJmlPaket">

                            <!-- Paket Details Summary -->
                            <div class="bg-[#F8F8F2] border border-[#E5E5DC] rounded-2xl p-4 flex justify-between items-center">
                                <div>
                                    <span class="text-xs text-gray-400 font-medium">Paket Terpilih</span>
                                    <h4 id="selectedPaketName" class="text-base font-bold font-serif text-brand-green">Prasmanan</h4>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-400 font-medium">Harga / Pax</span>
                                    <h4 id="selectedPaketPriceLabel" class="text-base font-extrabold text-gray-800">Rp 50.000</h4>
                                </div>
                            </div>

                            <!-- Lauk Selection -->
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Pilih Lauk Pilihan (<span id="laukCounter">0</span>/<span id="maxLaukLabel">0</span>)
                                </label>
                                <p class="text-xs text-gray-400 mb-3 font-light">Pilih lauk yang Anda inginkan sesuai batas paket Anda.</p>
                                
                                <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded-xl p-3 bg-[#FDFDFC]">
                                    @foreach($lauks as $lauk)
                                        <label class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg cursor-pointer text-xs select-none">
                                            <input type="checkbox" name="lauk_ids[]" value="{{ $lauk->id }}" onchange="updateLaukSelection(this)" class="lauk-checkbox rounded text-brand-green focus:ring-brand-green border-gray-300 w-4 h-4">
                                            <span class="text-gray-700 font-medium">{{ $lauk->nama_lauk }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                <p id="laukWarning" class="text-[11px] text-red-500 mt-1 hidden">Anda telah memilih batas maksimal lauk pauk.</p>
                            </div>

                            <!-- Pax Input -->
                            <div>
                                <label for="jumlahPaxInput" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Jumlah Pax / Porsi
                                </label>
                                <input type="number" id="jumlahPaxInput" name="jumlah_pax" min="10" value="50" required oninput="calculateLivePrice()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm">
                                <p class="text-[10px] text-gray-400 mt-1 font-light">Minimal pemesanan adalah 10 porsi (pax).</p>
                            </div>

                            <!-- Date Picker -->
                            <div>
                                <label for="tglAcaraInput" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Tanggal Acara
                                </label>
                                <input type="date" id="tglAcaraInput" name="tgl_acara" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm">
                                <p class="text-[10px] text-gray-400 mt-1 font-light">Pemesanan harus dilakukan minimal H+1 dari hari ini.</p>
                            </div>

                            <!-- Gubukan Stall Selection -->
                            <div>
                                <label for="gubukanSelect" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Stall Gubukan Tambahan (Opsional)
                                </label>
                                <select id="gubukanSelect" name="gubukan_id" onchange="calculateLivePrice()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm bg-white">
                                    <option value="" data-price="0">-- Tanpa Gubukan --</option>
                                    @foreach($gubukans as $gubukan)
                                        <option value="{{ $gubukan->id }}" data-price="{{ $gubukan->harga_gubukan }}">
                                            {{ $gubukan->nama_gubukan }} (+Rp {{ number_format($gubukan->harga_gubukan, 0, ',', '.') }} | Kp. {{ $gubukan->kapasitas_orang }} org)
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Catatan -->
                            <div>
                                <label for="catatanTextarea" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                                    Catatan Tambahan
                                </label>
                                <textarea id="catatanTextarea" name="catatan" rows="2" placeholder="Misal: Tolong level pedas sedang, pisahkan saus, dll." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm"></textarea>
                            </div>

                            <!-- Error Banner (AJAX Response Error) -->
                            <div id="errorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
                                <div class="flex">
                                    <div class="flex-shrink-0 text-red-500">⚠️</div>
                                    <div class="ml-3">
                                        <p id="errorText" class="text-xs text-red-700 font-medium"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Live Price Calculation Panel -->
                            <div class="bg-[#2D5A27]/5 border border-[#2D5A27]/10 rounded-2xl p-4 space-y-2">
                                <div class="flex justify-between items-center text-xs text-gray-600 font-light">
                                    <span>Subtotal Paket (<span id="calcPaxLabel">50</span> x <span id="calcPriceLabel">Rp 0</span>)</span>
                                    <span id="calcSubtotalPaket">Rp 0</span>
                                </div>
                                <div id="calcGubukanRow" class="flex justify-between items-center text-xs text-gray-600 font-light hidden">
                                    <span>Stall Gubukan</span>
                                    <span id="calcGubukanPrice">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center pt-2 border-t border-brand-green/10">
                                    <span class="text-sm font-bold text-gray-800">Total Harga</span>
                                    <span id="calcTotalPrice" class="text-base font-extrabold text-brand-green">Rp 0</span>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" id="submitBtn" class="w-full bg-brand-green bg-brand-green-hover text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer">
                                <span>Pesan Sekarang</span>
                                <div id="submitSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                            </button>
                        </form>
                    @endguest
                </div>
            </div>
        </div>

        <!-- SUCCESS SCREEN OVERLAY (Inside booking modal area) -->
        <div id="successOverlay" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
            <div class="bg-white rounded-3xl shadow-2xl p-8 text-center max-w-sm w-full space-y-6">
                <!-- Checkmark Animation Mock -->
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

        <!-- MODAL 2: USER ORDERS HISTORY MODAL (My Orders) -->
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
                                        <!-- Status Badge -->
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

                                        <!-- Produksi Badge -->
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

                                    <!-- Unpaid/Paid Status -->
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
                                            <!-- Pay Button if Approved and Unpaid -->
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

        <!-- CLIENT-SIDE VANILLA JAVASCRIPT FOR DYNAMIC INTERACTIONS -->
        <script>
            // Date bounds
            const dateInput = document.getElementById('tglAcaraInput');
            if (dateInput) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const year = tomorrow.getFullYear();
                const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
                const day = String(tomorrow.getDate()).padStart(2, '0');
                dateInput.min = `${year}-${month}-${day}`;
            }

            // Global State Variables for Booking
            let currentPackage = {
                id: null,
                name: '',
                price: 0,
                maxLauk: 0
            };
            let selectedLaukIds = [];

            // 1. OPEN BOOKING MODAL
            function openBookingModal(id, name, price, maxLauk) {
                const modal = document.getElementById('bookingModal');
                if (!modal) return;

                currentPackage = { id, name, price, maxLauk };
                selectedLaukIds = [];

                // Reset forms
                const form = document.getElementById('orderForm');
                if (form) {
                    form.reset();
                    // Reset lauk selections in DOM
                    const checkBoxes = document.querySelectorAll('.lauk-checkbox');
                    checkBoxes.forEach(cb => {
                        cb.checked = false;
                        cb.disabled = false;
                    });
                    document.getElementById('laukCounter').innerText = '0';
                    document.getElementById('laukWarning').classList.add('hidden');
                    document.getElementById('errorBanner').classList.add('hidden');
                }

                // Set package specific fields in Modal
                const titleLabel = document.getElementById('selectedPaketName');
                const priceLabel = document.getElementById('selectedPaketPriceLabel');
                const maxLaukLabel = document.getElementById('maxLaukLabel');
                const inputId = document.getElementById('inputPaketId');
                
                if (titleLabel) titleLabel.innerText = name;
                if (priceLabel) priceLabel.innerText = 'Rp ' + Number(price).toLocaleString('id-ID');
                if (maxLaukLabel) maxLaukLabel.innerText = maxLauk;
                if (inputId) inputId.value = id;

                // Open Modal with Transition
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
                }, 10);

                // Initial live calculations
                calculateLivePrice();
            }

            // 2. CLOSE BOOKING MODAL
            function closeBookingModal() {
                const modal = document.getElementById('bookingModal');
                if (!modal) return;
                modal.firstElementChild.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // OPEN & CLOSE LOGIN MODAL FOR GUESTS
            function openLoginModal() {
                const modal = document.getElementById('loginModal');
                if (!modal) return;
                
                // Reset form errors
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
                // Show loading/connection simulation
                alert("[GOOGLE LOGIN] Menghubungkan ke Google Account...\nBerhasil masuk sebagai Budi Santoso!");
                
                // Post Budi's seeded email and password to log in automatically
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

            // 3. LAUK CHECKBOX LOGIC (Enforces package lauk limit)
            function updateLaukSelection(checkbox) {
                const checkboxes = document.querySelectorAll('.lauk-checkbox');
                const checkedBoxes = Array.from(checkboxes).filter(cb => cb.checked);
                const count = checkedBoxes.length;

                // Update counter label
                const counterLabel = document.getElementById('laukCounter');
                if (counterLabel) counterLabel.innerText = count;

                // Limit checks
                const limit = currentPackage.maxLauk;
                const warning = document.getElementById('laukWarning');

                if (count >= limit) {
                    // Disable all other unchecked boxes
                    checkboxes.forEach(cb => {
                        if (!cb.checked) cb.disabled = true;
                    });
                    if (warning) warning.classList.remove('hidden');
                } else {
                    // Re-enable all boxes
                    checkboxes.forEach(cb => cb.disabled = false);
                    if (warning) warning.classList.add('hidden');
                }

                // Update state
                selectedLaukIds = checkedBoxes.map(cb => Number(cb.value));
            }

            // 4. LIVE PRICE CALCULATION
            function calculateLivePrice() {
                const paxInput = document.getElementById('jumlahPaxInput');
                if (!paxInput) return;

                const pax = Number(paxInput.value) || 0;
                
                // Set hidden input value for API item quantity
                const inputJml = document.getElementById('inputJmlPaket');
                if (inputJml) inputJml.value = pax;

                // Subtotal Paket calculation
                const subtotalPaket = pax * currentPackage.price;
                
                // Gubukan selection price
                const gubukanSelect = document.getElementById('gubukanSelect');
                let gubukanPrice = 0;
                if (gubukanSelect && gubukanSelect.selectedIndex > 0) {
                    const selectedOption = gubukanSelect.options[gubukanSelect.selectedIndex];
                    gubukanPrice = Number(selectedOption.getAttribute('data-price')) || 0;
                }

                // Total calculation
                const total = subtotalPaket + gubukanPrice;

                // Update DOM elements
                const calcPax = document.getElementById('calcPaxLabel');
                const calcPrice = document.getElementById('calcPriceLabel');
                const calcSubtotal = document.getElementById('calcSubtotalPaket');
                const calcGubukanPrice = document.getElementById('calcGubukanPrice');
                const calcGubukanRow = document.getElementById('calcGubukanRow');
                const calcTotal = document.getElementById('calcTotalPrice');

                if (calcPax) calcPax.innerText = pax;
                if (calcPrice) calcPrice.innerText = 'Rp ' + Number(currentPackage.price).toLocaleString('id-ID');
                if (calcSubtotal) calcSubtotal.innerText = 'Rp ' + subtotalPaket.toLocaleString('id-ID');
                
                if (gubukanPrice > 0) {
                    if (calcGubukanPrice) calcGubukanPrice.innerText = 'Rp ' + gubukanPrice.toLocaleString('id-ID');
                    if (calcGubukanRow) calcGubukanRow.classList.remove('hidden');
                } else {
                    if (calcGubukanRow) calcGubukanRow.classList.add('hidden');
                }

                if (calcTotal) calcTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
            }

            // 5. AJAX SUBMIT ORDER
            function submitOrder(event) {
                event.preventDefault();

                // Validate number of selected lauks
                if (selectedLaukIds.length !== currentPackage.maxLauk) {
                    showFormError(`Anda harus memilih tepat ${currentPackage.maxLauk} lauk untuk paket ini.`);
                    return;
                }

                const paxInput = document.getElementById('jumlahPaxInput').value;
                const tglAcara = document.getElementById('tglAcaraInput').value;
                const gubukanId = document.getElementById('gubukanSelect').value;
                const catatan = document.getElementById('catatanTextarea').value;

                // Show spinner and disable button
                const submitBtn = document.getElementById('submitBtn');
                const spinner = document.getElementById('submitSpinner');
                if (submitBtn) submitBtn.disabled = true;
                if (spinner) spinner.classList.remove('hidden');
                document.getElementById('errorBanner').classList.add('hidden');

                // Prepare request payload matching StorePesananRequest
                const payload = {
                    gubukan_id: gubukanId ? Number(gubukanId) : null,
                    tgl_acara: tglAcara,
                    jumlah_pax: Number(paxInput),
                    catatan: catatan,
                    items: [
                        {
                            paket_id: currentPackage.id,
                            jml_paket: Number(paxInput),
                            lauk_ids: selectedLaukIds
                        }
                    ]
                };

                // Fetch POST request to backend
                fetch('{{ route("web.pesanan.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(payload)
                })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw new Error(data.message || 'Terjadi kesalahan sistem.');
                        }
                        return data;
                    });
                })
                .then(data => {
                    // Success callback
                    closeBookingModal();
                    
                    // Show success screen overlay
                    const overlay = document.getElementById('successOverlay');
                    if (overlay) {
                        overlay.classList.remove('hidden');
                    }
                })
                .catch(error => {
                    // Error callback
                    showFormError(error.message);
                })
                .finally(() => {
                    // Hide spinner and enable button
                    if (submitBtn) submitBtn.disabled = false;
                    if (spinner) spinner.classList.add('hidden');
                });
            }

            // Show error in Modal form
            function showFormError(message) {
                const banner = document.getElementById('errorBanner');
                const text = document.getElementById('errorText');
                if (banner && text) {
                    text.innerText = message;
                    banner.classList.remove('hidden');
                }
            }

            function closeSuccessOverlay() {
                const overlay = document.getElementById('successOverlay');
                if (overlay) {
                    overlay.classList.add('hidden');
                }
                // Reload landing page to refresh order history
                window.location.reload();
            }

            // 6. OPEN & CLOSE ORDERS HISTORIES MODAL (My Orders)
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

            // 7. PAY WITH MIDTRANS SNAP (Mock/Real Snap Token execution)
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

        <!-- Inject Midtrans Snap JS for real transactions if needed -->
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

        <!-- Simple Animation Styling for Fade In -->
        <style>
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
    </body>
</html>
