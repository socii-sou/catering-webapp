@extends('layouts.app')

@section('title', $paket->nm_paket . ' - RASACI Catering')
@section('meta-description', 'Kustomisasi paket catering ' . $paket->nm_paket . ' Anda di RASACI Catering. Pilihlah lauk pilihan terbaik untuk acara Anda.')

@section('styles')
        <style>
            .active-lauk-card {
                border-color: #2D5A27 !important;
                background-color: rgba(45, 90, 39, 0.03) !important;
            }
            .prasmanan-lauk-card.active-card {
                border-color: #2D5A27 !important;
                background-color: rgba(45, 90, 39, 0.02) !important;
            }
        </style>
@endsection

@section('content')
        @php
            $isPrasmanan = str_contains(strtolower($paket->nm_paket), 'prasmanan');
            $heroImage = $isPrasmanan ? asset('images/prasmanan.jpg') : asset('images/nasi_kotak.jpg');

            if (!$isPrasmanan && str_contains(strtolower($paket->nm_paket), 'tumpeng')) {
                $heroImage = asset('images/tumpeng.jpg');
            }

            $paketDeskripsi = !empty($paket->deskripsi) ? $paket->deskripsi : 'Solusi praktis untuk rapat kantor, seminar, atau konsumsi panitia dengan cita rasa Nusantara yang konsisten dan higienis.';
            if (!str_contains($paketDeskripsi, 'dan higienis')) {
                $paketDeskripsi = rtrim($paketDeskripsi, '.') . ' dan higienis.';
            }
        @endphp

        <!-- Main Content Area -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

            @if($isPrasmanan)
                <!-- ================= PRASMANAN DETAIL PAGE (MATCHING USER MOCKUP EXACTLY) ================= -->
                
                <!-- Hero Bento Section -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-12">
                    <!-- Left Main Image with Headline Overlay (Span 7) -->
                    <div class="lg:col-span-7 relative h-[300px] sm:h-[360px] lg:h-[400px] overflow-hidden rounded-3xl ambient-shadow">
                        <img src="{{ $heroImage }}" alt="Paket Prasmanan Rasaci" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent flex flex-col justify-end p-6 sm:p-8 text-white">
                            <h1 class="text-3xl sm:text-4xl font-bold font-serif leading-tight mb-2">Paket Prasmanan Rasaci</h1>
                            <p class="text-xs sm:text-sm text-gray-200 font-light leading-relaxed max-w-lg">
                                Sajian prasmanan premium untuk acara pernikahan, gathering kantor, atau syukuran dengan pilihan menu autentik Nusantara.
                            </p>
                        </div>
                    </div>

                    <!-- Right Column (Span 5) -->
                    <div class="lg:col-span-5 flex flex-col gap-4">
                        <!-- Top Row: 2 Small Images -->
                        <div class="grid grid-cols-2 gap-4 h-[140px] sm:h-[170px] lg:h-[185px]">
                            <div class="overflow-hidden rounded-3xl ambient-shadow">
                                <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&q=80&w=600" alt="Sate Grill" class="w-full h-full object-cover">
                            </div>
                            <div class="overflow-hidden rounded-3xl ambient-shadow">
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=600" alt="Sambal & Dishes" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Bottom Card: Higienis & Halal (Dark Olive Box) -->
                        <div class="bg-[#485116] text-white p-6 rounded-3xl flex items-start gap-4 shadow-md flex-1">
                            <div class="w-9 h-9 rounded-full bg-white/10 flex items-center justify-center text-amber-300 text-base shrink-0 mt-0.5">
                                🛡️
                            </div>
                            <div class="space-y-1">
                                <span class="text-[10px] font-bold text-amber-300 uppercase tracking-widest block">PILIHAN TERPERCAYA</span>
                                <h3 class="text-lg sm:text-xl font-bold font-serif text-white">Higienis & Halal</h3>
                                <p class="text-xs text-gray-200 font-light leading-relaxed">
                                    Setiap masakan diproses dengan standar kebersihan tertinggi dan bahan baku segar bersertifikasi halal.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Two Column Layout: Main Configurator + Sticky Sidebar -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    
                    <!-- Left Column: Configurator -->
                    <div class="lg:col-span-8 space-y-10">
                        
                        <!-- 1. Pilih Jenis Paket Section -->
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-serif font-bold flex items-center justify-center text-sm shrink-0">
                                    1
                                </div>
                                <h2 class="text-2xl font-bold font-serif text-gray-900">Pilih Jenis Paket</h2>
                            </div>

                            <!-- Options Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Card Standard (Active) -->
                                <div onclick="selectPrasmananVariant(this, 65000, 3, 'Paket Standard')" 
                                     class="prasmanan-variant-card p-5 bg-[#FDFDF6] rounded-2xl border-2 border-gray-900 relative shadow-sm cursor-pointer select-none">
                                    <span class="active-badge absolute top-4 right-4 bg-black text-white text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">AKTIF</span>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Paket Standard</h3>
                                    <p class="text-xs text-gray-500 font-light mb-4">Kuota 3 Lauk (1 Ayam + 1 Daging + 1 Sayur).</p>
                                    <div class="text-xs text-gray-500 font-light">
                                        Mulai dari <span class="text-sm font-extrabold text-gray-900">Rp 65.000</span> <span class="text-[10px]">/ pax</span>
                                    </div>
                                </div>

                                <!-- Card Premium -->
                                <div onclick="selectPrasmananVariant(this, 95000, 5, 'Paket Premium')" 
                                     class="prasmanan-variant-card p-5 bg-[#FDFDF6] rounded-2xl border border-gray-200 relative shadow-sm hover:border-gray-400 transition-all cursor-pointer select-none">
                                    <span class="active-badge hidden absolute top-4 right-4 bg-black text-white text-[9px] font-bold uppercase tracking-wider px-2.5 py-1 rounded-full">AKTIF</span>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Paket Premium</h3>
                                    <p class="text-xs text-gray-500 font-light mb-4">Kuota 5 Lauk (2 Ayam + 2 Daging + 1 Sayur).</p>
                                    <div class="text-xs text-gray-500 font-light">
                                        Mulai dari <span class="text-sm font-extrabold text-gray-900">Rp 95.000</span> <span class="text-[10px]">/ pax</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Kustomisasi Menu Section -->
                        <div class="space-y-8">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-serif font-bold flex items-center justify-center text-sm shrink-0">
                                    2
                                </div>
                                <h2 class="text-2xl font-bold font-serif text-gray-900">Kustomisasi Menu</h2>
                            </div>

                            <!-- Category: Aneka Ayam -->
                            <div class="space-y-3">
                                <h3 class="text-sm font-bold font-serif text-gray-800 flex items-center gap-2">
                                    <span>🍴</span> Aneka Ayam
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Ayam Goreng (Checked) -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=400" alt="Ayam Goreng" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Ayam Goreng</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-xs font-bold">✓</div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="1" checked class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Ayam Bakar -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&q=80&w=400" alt="Ayam Bakar" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Ayam Bakar</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-xs font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="2" class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Sate Ayam -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&q=80&w=400" alt="Sate Ayam" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Sate Ayam</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-xs font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="4" class="hidden lauk-checkbox">
                                    </div>
                                </div>
                            </div>

                            <!-- Category: Aneka Daging -->
                            <div class="space-y-3">
                                <h3 class="text-sm font-bold font-serif text-gray-800 flex items-center gap-2">
                                    <span>🍲</span> Aneka Daging
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Rendang Sapi (Checked) -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=400" alt="Rendang Sapi" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Rendang Sapi</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-xs font-bold">✓</div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="3" checked class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Empal Gepuk -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=400" alt="Empal Gepuk" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Empal Gepuk</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-xs font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="5" class="hidden lauk-checkbox">
                                    </div>
                                </div>
                            </div>

                            <!-- Category: Aneka Sayur -->
                            <div class="space-y-3">
                                <h3 class="text-sm font-bold font-serif text-gray-800 flex items-center gap-2">
                                    <span>🥬</span> Aneka Sayur
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                    <!-- Tumis Buncis (Checked) -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&q=80&w=400" alt="Tumis Buncis" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Tumis Buncis</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-xs font-bold">✓</div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="6" checked class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Capcay -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=400" alt="Capcay" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Capcay</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-xs font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="7" class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Urap Sayur -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-28 rounded-xl overflow-hidden mb-2 relative">
                                            <img src="https://images.unsplash.com/photo-1543339308-43e59d6b73a6?auto=format&fit=crop&q=80&w=400" alt="Urap Sayur" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-1">
                                            <span class="text-xs font-bold text-gray-900">Urap Sayur</span>
                                            <div class="check-box-icon w-5 h-5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-xs font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="8" class="hidden lauk-checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Standard Menu Banner -->
                        <div class="p-6 bg-[#EBF5E8]/80 rounded-2xl border border-[#D2E6CE] flex items-start gap-4 shadow-sm">
                            <div class="w-7 h-7 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold text-brand-green shrink-0 mt-0.5">
                                ℹ️
                            </div>
                            <div class="space-y-1.5 text-xs text-gray-700">
                                <h4 class="font-bold text-gray-900 text-sm">Informasi Menu Standar</h4>
                                <p class="leading-relaxed font-light">
                                    Setiap paket prasmanan sudah termasuk: <strong class="font-bold text-gray-900">Nasi Putih</strong>, <strong class="font-bold text-gray-900">Kerupuk</strong>, <strong class="font-bold text-gray-900">Sambal khas Rasaci</strong>, dan <strong class="font-bold text-gray-900">Dessert (Buah Potong/Pudding)</strong>. Peralatan saji, alat makan standar, dan tenaga waiter sudah termasuk dalam paket.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Sticky Sidebar -->
                    <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                        <div class="bg-white rounded-3xl overflow-hidden ambient-shadow border border-[#E5E5DC] p-6 space-y-6">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">MULAI DARI</span>
                                <div class="flex items-baseline gap-1">
                                    <span id="sidebarPriceLabel" class="text-2xl font-extrabold text-gray-900 font-serif">Rp 65.000</span>
                                    <span class="text-xs text-gray-500 font-light">/ pax</span>
                                </div>
                            </div>

                            <form id="prasmananOrderForm" onsubmit="submitDetailOrder(event)" class="space-y-5">
                                @csrf
                                <input type="hidden" name="items[0][paket_id]" value="{{ $paket->id }}">
                                <input type="hidden" name="items[0][jml_paket]" id="prasmananInputJmlPaket" value="20">

                                <!-- Date Picker -->
                                <div class="space-y-1.5">
                                    <label for="detailTglAcara" class="block text-[11px] font-semibold text-gray-700">Tanggal Pengiriman</label>
                                    <input type="date" id="detailTglAcara" name="tgl_acara" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-[#F8F9F3]">
                                </div>

                                <!-- Pax Input -->
                                <div class="space-y-1.5">
                                    <div class="flex justify-between items-center text-[11px] font-semibold text-gray-700">
                                        <span>Jumlah Pesanan (Pax)</span>
                                        <span class="text-[10px] text-gray-400 font-normal">Min. 30 pax</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button type="button" onclick="decrementPax()" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">-</button>
                                        <input type="number" id="detailJumlahPax" name="jumlah_pax" min="30" value="20" required oninput="calculateDetailPrice()" class="flex-1 text-center font-bold text-base bg-white border border-gray-200 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2D5A27]">
                                        <button type="button" onclick="incrementPax()" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">+</button>
                                    </div>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="pt-4 border-t border-gray-100 space-y-2 text-xs">
                                    <div class="flex justify-between text-gray-600 font-light">
                                        <span>Harga per pax</span>
                                        <span id="summaryHargaPerPax">Rp 65.000</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600 font-light">
                                        <span>Biaya Layanan</span>
                                        <span class="text-green-700 font-medium">Gratis</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                                        <span class="text-sm font-bold text-gray-900">Subtotal</span>
                                        <span id="detailTotal" class="text-base font-extrabold text-gray-900">Rp 1.300.000</span>
                                    </div>
                                </div>

                                <!-- Error Banner -->
                                <div id="detailErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                                    <p id="detailErrorText" class="text-[11px] text-red-700 font-medium"></p>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" id="detailSubmitBtn" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs">
                                    <span>Pesan Sekarang</span>
                                    <div id="detailSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                </button>
                            </form>
                        </div>

                        <!-- WhatsApp Box -->
                        <div class="p-4 bg-[#EBF5E8] border border-[#D2E6CE] rounded-2xl flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-[#2D5A27]/10 text-brand-green flex items-center justify-center text-base shrink-0">
                                💬
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-gray-900">Konsultasi Menu Corporate?</h4>
                                <a href="https://wa.me/6281234567890?text=Halo%20RASACI%20Catering,%20saya%20tertarik%20mengenai%20paket%20Prasmanan" target="_blank" class="text-[#2D5A27] font-semibold text-[11px] hover:underline inline-flex items-center gap-1">
                                    Chat via WhatsApp &gt;
                                </a>
                            </div>
                        </div>
                    </aside>

                </div>

            @else
                <!-- ================= NASI KOTAK DETAIL PAGE ================= -->
                
                <!-- Single Hero Image Section with Frosted Glass Headline Overlay Card -->
                <section class="relative w-full overflow-hidden rounded-3xl ambient-shadow mb-16" style="height: 440px; min-height: 440px; position: relative;">
                    <!-- Hero Background Image -->
                    <img src="{{ $heroImage }}" alt="{{ $paket->nm_paket }}" class="w-full h-full object-cover" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <!-- Bottom gradient overlay for contrast -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none" style="position: absolute; inset: 0;"></div>

                    <!-- Headline Overlay Card (max-w-xs sm:max-w-sm, rounded-3xl, bg-[#EAEFE2]/95 backdrop-blur-md) -->
                    <div class="absolute bottom-6 left-6 right-6 sm:right-auto max-w-xs sm:max-w-sm bg-[#EAEFE2]/95 backdrop-blur-md p-5 rounded-3xl shadow-2xl border border-white/80 z-20" style="position: absolute; bottom: 24px; left: 24px; background-color: rgba(234, 239, 226, 0.95); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
                        <span class="text-[10px] font-bold text-[#4F6B38] uppercase tracking-widest block mb-1">EKSKLUSIF NUSANTARA</span>
                        <h1 class="text-2xl sm:text-3xl font-bold font-serif text-gray-900 mb-2 leading-tight">{{ $paket->nm_paket }}</h1>
                        <p class="text-xs text-gray-700 font-light leading-relaxed">
                            {{ $paketDeskripsi }}
                        </p>
                    </div>
                </section>

                <!-- Two Column Layout: Lauk Customization + Booking Sidebar -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
                    
                    <!-- Left Column: Lauk Customization -->
                    <div class="lg:col-span-8 space-y-8">
                        
                        <!-- Section Heading -->
                        <div class="flex items-center space-x-3 text-brand-green">
                            <span class="text-2xl">🍽️</span>
                            <h1 class="text-2xl font-bold font-serif text-gray-900">Kustomisasi Lauk</h1>
                        </div>

                        <!-- Alert Info Banner -->
                        <div class="bg-[#EBF5E8] border border-[#D2E6CE] rounded-2xl p-4 flex items-center gap-3 text-brand-green text-xs">
                            <div class="w-6 h-6 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold shrink-0 text-brand-green">
                                ℹ️
                            </div>
                            <p class="text-[#2B4E25] font-medium text-xs leading-relaxed">
                                <span class="font-bold">Maksimal Custom Varian Lauk:</span> Pilih hingga {{ $paket->jumlah_lauk_pilihan }} varian lauk utama untuk set menu Anda.
                            </p>
                        </div>

                        @php
                            $groupedLauks = $lauks->groupBy(function($lauk) {
                                return $lauk->kategoriLauk?->nama_kategori ?? 'Lauk Utama';
                            });
                        @endphp

                        @php $categoryIndex = 1; @endphp
                        @foreach($groupedLauks as $categoryName => $lauksInGroup)
                            <!-- Category Section -->
                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b border-[#E5E5DC] pb-2">
                                    <h3 class="text-base font-bold font-serif text-gray-900">{{ $categoryIndex }}. {{ $categoryName }}</h3>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">MAKSIMAL {{ $paket->jumlah_lauk_pilihan }}</span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($lauksInGroup as $index => $lauk)
                                        @php
                                            $lName = strtolower($lauk->nama_lauk);
                                            $laukThumbnails = [
                                                'rendang' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=200',
                                                'ayam' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=200',
                                                'empal' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=200',
                                                'ikan' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&q=80&w=200',
                                                'sate' => 'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&q=80&w=200',
                                                'default' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=200',
                                            ];
                                            $thumbUrl = $laukThumbnails['default'];
                                            foreach ($laukThumbnails as $k => $u) {
                                                if (str_contains($lName, $k)) { $thumbUrl = $u; break; }
                                            }

                                            $isPrechecked = false;
                                            if ($loop->parent->first && $index < $paket->jumlah_lauk_pilihan && ($lName === 'rendang daging sapi' || $lName === 'ayam goreng serundeng' || $lName === 'rendang sapi' || $lName === 'ayam goreng' || $index < 2)) {
                                                $isPrechecked = true;
                                            }
                                        @endphp

                                        <div onclick="toggleLaukCard(this, {{ $paket->jumlah_lauk_pilihan }})" 
                                             data-lauk-id="{{ $lauk->id }}"
                                             class="lauk-card p-4 bg-[#FDFDF6] rounded-2xl border border-[#E5E5DC] relative ambient-shadow hover:shadow-md transition-all cursor-pointer select-none flex items-center gap-4 @if($isPrechecked) active-lauk-card @endif">
                                            
                                            <input type="checkbox" name="lauk_ids[]" value="{{ $lauk->id }}" @if($isPrechecked) checked @endif class="lauk-checkbox hidden">
                                            
                                            <img src="{{ $thumbUrl }}" alt="{{ $lauk->nama_lauk }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl shrink-0">

                                            <div class="flex-1 min-w-0 pr-6">
                                                <h4 class="font-bold text-gray-900 text-sm mb-1 truncate">{{ $lauk->nama_lauk }}</h4>
                                                <p class="text-xs text-gray-500 font-light leading-relaxed line-clamp-2">
                                                    @if(!empty($lauk->keterangan))
                                                        {{ $lauk->keterangan }}
                                                    @elseif(str_contains($lName, 'rendang'))
                                                        Dimasak 8 jam dengan bumbu rempah otentik.
                                                    @elseif(str_contains($lName, 'serundeng') || str_contains($lName, 'ayam goreng'))
                                                        Ayam pejantan gurih dengan taburan kelapa.
                                                    @elseif(str_contains($lName, 'empal'))
                                                        Daging empuk dengan rasa manis gurih meresap.
                                                    @elseif(str_contains($lName, 'ikan') || str_contains($lName, 'rica'))
                                                        Fillet ikan kakap segar dengan sambal rica pedas.
                                                    @elseif(str_contains($lName, 'ayam bakar'))
                                                        Ayam pejantan dibakar dengan kecap rempah pilihan.
                                                    @elseif(str_contains($lName, 'sate'))
                                                        Sate ayam empuk disiram bumbu kacang gurih.
                                                    @elseif(str_contains($lName, 'udang'))
                                                        Udang segar balado dengan bumbu cabai pedas manis.
                                                    @elseif(str_contains($lName, 'cumi'))
                                                        Cumi empuk dimasak saus padang kaya rasa.
                                                    @elseif(str_contains($lName, 'telur'))
                                                        Telur balado khas Nusantara dengan rasa pedas gurih.
                                                    @elseif(str_contains($lName, 'tahu') || str_contains($lName, 'tempe'))
                                                        Tahu tempe bacem gurih manis bumbu rempah.
                                                    @else
                                                        Pilihan lauk khas Nusantara dengan cita rasa gurih dan bumbu rempah melimpah.
                                                    @endif
                                                </p>
                                            </div>

                                            <div class="absolute top-3.5 right-3.5 check-indicator @if(!$isPrechecked) hidden @endif bg-[#2D5A27] text-white rounded-md w-5 h-5 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-3.5 h-3.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                                </svg>
                                            </div>
                                            <div class="absolute top-3.5 right-3.5 box-indicator @if($isPrechecked) hidden @endif border border-gray-300 w-5 h-5 rounded-md bg-white"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @php $categoryIndex++; @endphp
                        @endforeach

                        <!-- Standard Menu Info Banner -->
                        <div class="p-6 bg-[#EBF5E8]/60 rounded-2xl border border-[#D2E6CE] flex items-start gap-4 shadow-sm">
                            <div class="w-7 h-7 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold text-brand-green shrink-0 mt-0.5">
                                ℹ️
                            </div>
                            <div class="space-y-3">
                                <h4 class="font-bold text-gray-900 text-sm">Informasi Menu Standar</h4>
                                <p class="text-xs text-gray-600 font-light leading-relaxed">
                                    Setiap paket sudah termasuk <strong class="font-bold text-gray-800">Sayuran (Tumis Buncis Jagung Muda)</strong>, <strong class="font-bold text-gray-800">Sambal</strong>, dan <strong class="font-bold text-gray-800">Kentang Balado/Cabai</strong>.
                                </p>
                                <div class="flex flex-wrap gap-2 pt-1">
                                    <span class="px-3 py-1 bg-[#DCECD8] text-[#2D5A27] text-[11px] font-semibold rounded-full">Sayuran</span>
                                    <span class="px-3 py-1 bg-[#DCECD8] text-[#2D5A27] text-[11px] font-semibold rounded-full">Sambal</span>
                                    <span class="px-3 py-1 bg-[#DCECD8] text-[#2D5A27] text-[11px] font-semibold rounded-full">Kentang Balado</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Sticky Booking Summary -->
                    <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                        <div class="bg-white rounded-3xl overflow-hidden ambient-shadow border border-[#E5E5DC]">
                            <div class="bg-[#2D5A27] p-6 text-white">
                                <span class="text-[11px] font-light tracking-wide block mb-1 text-gray-200">Mulai Dari</span>
                                <div class="flex items-baseline gap-1">
                                    <span class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                                    <span class="text-xs font-light text-gray-200">/ pax</span>
                                </div>
                            </div>

                            <div class="p-6 space-y-6 bg-[#FAF9F5]/40">
                                <form id="detailOrderForm" onsubmit="submitDetailOrder(event)" class="space-y-5">
                                    @csrf
                                    <input type="hidden" name="items[0][paket_id]" value="{{ $paket->id }}">
                                    <input type="hidden" name="items[0][jml_paket]" id="detailInputJmlPaket" value="20">

                                    <div class="space-y-1.5">
                                        <label for="detailTglAcara" class="block text-[11px] font-semibold text-gray-700">Tanggal Pengiriman</label>
                                        <input type="date" id="detailTglAcara" name="tgl_acara" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-white">
                                    </div>

                                    <div class="space-y-1.5">
                                        <label class="block text-[11px] font-semibold text-gray-700">Jumlah Pesanan (Pax)</label>
                                        <div class="flex items-center gap-3">
                                            <button type="button" onclick="decrementPax()" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">-</button>
                                            <input type="number" id="detailJumlahPax" name="jumlah_pax" min="10" value="20" required oninput="calculateDetailPrice()" class="flex-1 text-center font-bold text-base bg-white border border-gray-200 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2D5A27]">
                                            <button type="button" onclick="incrementPax()" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">+</button>
                                        </div>
                                        <p class="text-[10px] text-gray-400 font-light text-center italic">*Minimal pemesanan 10 pax</p>
                                    </div>

                                    <div class="pt-4 border-t border-[#E5E5DC] space-y-2.5">
                                        <div class="flex justify-between text-xs text-gray-600 font-light">
                                            <span>Harga Dasar</span>
                                            <span>Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-600 font-light">
                                            <span>Subtotal</span>
                                            <span id="detailSubtotal">Rp {{ number_format($paket->harga_paket * 20, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="border-t border-dashed border-gray-300 pt-3 flex justify-between items-center">
                                            <span class="text-xs font-bold text-gray-900">Total Estimasi</span>
                                            <span id="detailTotal" class="text-base font-extrabold text-[#2D5A27]">Rp {{ number_format($paket->harga_paket * 20, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div id="detailErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                                        <p id="detailErrorText" class="text-[11px] text-red-700 font-medium"></p>
                                    </div>

                                    <button type="submit" id="detailSubmitBtn" class="w-full bg-[#2D5A27] hover:bg-[#22451E] text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs uppercase tracking-wider">
                                        <span>Pesan Sekarang</span>
                                        <div id="detailSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </aside>

                </div>

            @endif

        </main>
@endsection

@section('scripts')
        <script>
            // Date bounds
            const detailDateInput = document.getElementById('detailTglAcara');
            if (detailDateInput) {
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const year = tomorrow.getFullYear();
                const month = String(tomorrow.getMonth() + 1).padStart(2, '0');
                const day = String(tomorrow.getDate()).padStart(2, '0');
                detailDateInput.min = `${year}-${month}-${day}`;
            }

            // Price configurations
            let currentUnitPrice = {{ $isPrasmanan ? 65000 : $paket->harga_paket }};
            let currentMaxLauk = {{ $paket->jumlah_lauk_pilihan }};
            let selectedLaukIds = [1, 3, 6];

            // Prasmanan Variant Selection
            function selectPrasmananVariant(card, price, maxLauk, name) {
                document.querySelectorAll('.prasmanan-variant-card').forEach(c => {
                    c.classList.remove('border-2', 'border-gray-900');
                    c.classList.add('border', 'border-gray-200');
                    c.querySelector('.active-badge')?.classList.add('hidden');
                });
                card.classList.remove('border', 'border-gray-200');
                card.classList.add('border-2', 'border-gray-900');
                card.querySelector('.active-badge')?.classList.remove('hidden');

                currentUnitPrice = price;
                currentMaxLauk = maxLauk;

                const label = document.getElementById('sidebarPriceLabel');
                if (label) label.innerText = 'Rp ' + price.toLocaleString('id-ID');

                const summaryLabel = document.getElementById('summaryHargaPerPax');
                if (summaryLabel) summaryLabel.innerText = 'Rp ' + price.toLocaleString('id-ID');

                calculateDetailPrice();
            }

            // Prasmanan Lauk Toggle
            function togglePrasmananLauk(card) {
                const checkbox = card.querySelector('.lauk-checkbox');
                const icon = card.querySelector('.check-box-icon');

                if (checkbox.checked) {
                    checkbox.checked = false;
                    card.classList.remove('active-card', 'border-2', 'border-[#2D5A27]');
                    card.classList.add('border', 'border-gray-200');
                    icon.className = "check-box-icon w-5 h-5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-xs font-bold";
                    icon.innerText = "";
                    selectedLaukIds = selectedLaukIds.filter(id => id !== Number(checkbox.value));
                } else {
                    if (selectedLaukIds.length >= currentMaxLauk) {
                        alert(`Anda hanya boleh memilih maksimal ${currentMaxLauk} lauk untuk varian paket ini.`);
                        return;
                    }
                    checkbox.checked = true;
                    card.classList.add('active-card', 'border-2', 'border-[#2D5A27]');
                    card.classList.remove('border', 'border-gray-200');
                    icon.className = "check-box-icon w-5 h-5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-xs font-bold";
                    icon.innerText = "✓";
                    selectedLaukIds.push(Number(checkbox.value));
                }
            }

            // Nasi Kotak Lauk Card Toggle
            function toggleLaukCard(card, limit) {
                const checkbox = card.querySelector('.lauk-checkbox');
                const checkIndicator = card.querySelector('.check-indicator');
                const boxIndicator = card.querySelector('.box-indicator');

                if (checkbox.checked) {
                    checkbox.checked = false;
                    card.classList.remove('active-lauk-card');
                    if (checkIndicator) checkIndicator.classList.add('hidden');
                    if (boxIndicator) boxIndicator.classList.remove('hidden');
                    selectedLaukIds = selectedLaukIds.filter(id => id !== Number(checkbox.value));
                } else {
                    if (selectedLaukIds.length >= limit) {
                        alert(`Anda hanya boleh memilih maksimal ${limit} lauk untuk paket ini.`);
                        return;
                    }
                    checkbox.checked = true;
                    card.classList.add('active-lauk-card');
                    if (checkIndicator) checkIndicator.classList.remove('hidden');
                    if (boxIndicator) boxIndicator.classList.add('hidden');
                    selectedLaukIds.push(Number(checkbox.value));
                }
            }

            // Increment / Decrement
            function incrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const step = {{ $isPrasmanan ? 10 : 10 }};
                input.value = parseInt(input.value) + step;
                calculateDetailPrice();
            }

            function decrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const min = {{ $isPrasmanan ? 30 : 10 }};
                const step = 10;
                const current = parseInt(input.value);
                if (current > min) {
                    input.value = current - step;
                    calculateDetailPrice();
                }
            }

            function calculateDetailPrice() {
                const paxInput = document.getElementById('detailJumlahPax');
                const inputJml = document.getElementById('prasmananInputJmlPaket') || document.getElementById('detailInputJmlPaket');
                if (!paxInput) return;

                const pax = Number(paxInput.value) || 0;
                if (inputJml) inputJml.value = pax;

                const subtotal = pax * currentUnitPrice;
                const formatted = 'Rp ' + subtotal.toLocaleString('id-ID');

                const summaryLabel = document.getElementById('summaryHargaPerPax');
                if (summaryLabel) summaryLabel.innerText = 'Rp ' + currentUnitPrice.toLocaleString('id-ID');

                const subtotalLabel = document.getElementById('detailSubtotal');
                if (subtotalLabel) subtotalLabel.innerText = formatted;

                const totalLabel = document.getElementById('detailTotal');
                if (totalLabel) totalLabel.innerText = formatted;
            }

            // AJAX Submit
            function submitDetailOrder(event) {
                event.preventDefault();

                @guest
                    openLoginModal();
                    return;
                @endguest

                const paxInput = document.getElementById('detailJumlahPax').value;
                const tglAcara = document.getElementById('detailTglAcara').value;

                const submitBtn = document.getElementById('detailSubmitBtn');
                const spinner = document.getElementById('detailSpinner');
                if (submitBtn) submitBtn.disabled = true;
                if (spinner) spinner.classList.remove('hidden');
                document.getElementById('detailErrorBanner').classList.add('hidden');

                const payload = {
                    tgl_acara: tglAcara,
                    jumlah_pax: Number(paxInput),
                    items: [
                        {
                            paket_id: {{ $paket->id }},
                            jml_paket: Number(paxInput),
                            lauk_ids: selectedLaukIds
                        }
                    ]
                };

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
                    const overlay = document.getElementById('successOverlay');
                    if (overlay) overlay.classList.remove('hidden');
                })
                .catch(error => {
                    showDetailError(error.message);
                })
                .finally(() => {
                    if (submitBtn) submitBtn.disabled = false;
                    if (spinner) spinner.classList.add('hidden');
                });
            }

            function showDetailError(message) {
                const banner = document.getElementById('detailErrorBanner');
                const text = document.getElementById('detailErrorText');
                if (banner && text) {
                    text.innerText = message;
                    banner.classList.remove('hidden');
                }
            }
        </script>
@endsection
