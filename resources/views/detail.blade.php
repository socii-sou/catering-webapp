@extends('layouts.app')

@section('title', 'Paket ' . $paket->nm_paket . ' - RASACI Catering')
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

            $hargaAwal = (int) $paket->harga_paket > 0 ? (int) $paket->harga_paket : ($isPrasmanan ? 65000 : 35000);
            $minPax = $isPrasmanan ? 20 : 10;
        @endphp

        <!-- Main Content Area -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 w-full">

            @if($isPrasmanan)
                <!-- ================= PRASMANAN DETAIL PAGE ================= -->
                
                <!-- Hero Bento Section (Compact image heights) -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-8">
                    <!-- Left Main Image with Headline Overlay (Span 7) -->
                    <div class="lg:col-span-7 relative h-[210px] sm:h-[240px] lg:h-[260px] overflow-hidden rounded-3xl ambient-shadow">
                        <img src="{{ $heroImage }}" alt="Paket Prasmanan Rasaci" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/35 to-transparent flex flex-col justify-end p-5 sm:p-6 text-white">
                            <h1 class="text-2xl sm:text-3xl font-bold font-serif leading-tight mb-1">Paket Prasmanan Rasaci</h1>
                            <p class="text-xs text-gray-200 font-light leading-relaxed max-w-lg">
                                Sajian prasmanan premium untuk acara pernikahan, gathering kantor, atau syukuran dengan pilihan menu autentik Nusantara.
                            </p>
                        </div>
                    </div>

                    <!-- Right Column (Span 5) -->
                    <div class="lg:col-span-5 flex flex-col gap-3">
                        <!-- Top Row: 2 Small Images -->
                        <div class="grid grid-cols-2 gap-3 h-[95px] sm:h-[110px] lg:h-[118px]">
                            <div class="overflow-hidden rounded-2xl ambient-shadow">
                                <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&q=80&w=600" alt="Sate Grill" class="w-full h-full object-cover">
                            </div>
                            <div class="overflow-hidden rounded-2xl ambient-shadow">
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=600" alt="Sambal & Dishes" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Bottom Card: Higienis & Halal (Dark Olive Box matching mockup) -->
                        <div class="bg-[#434B19] text-white p-4 sm:p-5 rounded-2xl flex items-start gap-3.5 shadow-md flex-1">
                            <div class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center text-amber-300 text-sm shrink-0 mt-0.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 text-amber-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                                </svg>
                            </div>
                            <div class="space-y-0.5">
                                <span class="text-[9px] font-bold text-amber-300 uppercase tracking-widest block">PILIHAN TERPERCAYA</span>
                                <h3 class="text-base sm:text-lg font-bold font-serif text-white">Higienis & Halal</h3>
                                <p class="text-[11px] text-gray-200 font-light leading-relaxed">
                                    Setiap masakan diproses dengan standar kebersihan tertinggi dan bahan baku segar bersertifikasi halal.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Two Column Layout: Main Configurator + Sticky Sidebar -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Left Column: Configurator (Span 8) -->
                    <div class="lg:col-span-8 space-y-8">
                        
                        <!-- 1. Pilih Jenis Paket Section -->
                        <div class="space-y-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-7 h-7 rounded-full bg-[#3B420C] text-white font-serif font-bold flex items-center justify-center text-xs shrink-0">
                                    1
                                </div>
                                <h2 class="text-xl font-bold font-serif text-gray-900">Pilih Jenis Paket</h2>
                            </div>

                            <!-- Options Grid -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <!-- Card Standard (Active by default) -->
                                <div onclick="selectPrasmananVariant(this, 65000, 3, 'Paket Standard')" 
                                     class="prasmanan-variant-card p-4 sm:p-5 bg-[#FDFDF6] rounded-2xl border-2 border-gray-900 relative shadow-sm cursor-pointer select-none">
                                    <span class="active-badge absolute top-4 right-4 bg-black text-white text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">AKTIF</span>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Paket Standard</h3>
                                    <p class="text-xs text-gray-500 font-light mb-3">Kuota 3 Lauk (1 Ayam + 1 Daging + 1 Sayur).</p>
                                    <div class="text-xs text-gray-500 font-light">
                                        Mulai dari <span class="text-sm font-extrabold text-gray-900">Rp 65.000</span> <span class="text-[10px]">/pax</span>
                                    </div>
                                </div>

                                <!-- Card Premium -->
                                <div onclick="selectPrasmananVariant(this, 95000, 5, 'Paket Premium')" 
                                     class="prasmanan-variant-card p-4 sm:p-5 bg-[#FDFDF6] rounded-2xl border border-gray-200 relative shadow-sm hover:border-gray-400 transition-all cursor-pointer select-none">
                                    <span class="active-badge hidden absolute top-4 right-4 bg-black text-white text-[9px] font-bold uppercase tracking-wider px-2.5 py-0.5 rounded-full">AKTIF</span>
                                    <h3 class="text-base font-bold font-serif text-gray-900 mb-1">Paket Premium</h3>
                                    <p class="text-xs text-gray-500 font-light mb-3">Kuota 5 Lauk (2 Ayam + 2 Daging + 1 Sayur).</p>
                                    <div class="text-xs text-gray-500 font-light">
                                        Mulai dari <span class="text-sm font-extrabold text-gray-900">Rp 95.000</span> <span class="text-[10px]">/pax</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Kustomisasi Menu Section -->
                        <div class="space-y-6">
                            <div class="flex items-center space-x-3">
                                <div class="w-7 h-7 rounded-full bg-[#3B420C] text-white font-serif font-bold flex items-center justify-center text-xs shrink-0">
                                    2
                                </div>
                                <h2 class="text-xl font-bold font-serif text-gray-900">Kustomisasi Menu</h2>
                            </div>

                            <!-- Category: Aneka Ayam -->
                            <div class="space-y-2.5">
                                <h3 class="text-xs font-bold font-serif text-gray-800 flex items-center gap-2">
                                    <span>🍴</span> Aneka Ayam
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <!-- Ayam Goreng (Checked) -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=300" alt="Ayam Goreng" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Ayam Goreng</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="1" checked class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Ayam Bakar -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&q=80&w=300" alt="Ayam Bakar" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Ayam Bakar</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="2" class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Sate Ayam -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&q=80&w=300" alt="Sate Ayam" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Sate Ayam</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="4" class="hidden lauk-checkbox">
                                    </div>
                                </div>
                            </div>

                            <!-- Category: Aneka Daging -->
                            <div class="space-y-2.5">
                                <h3 class="text-xs font-bold font-serif text-gray-800 flex items-center gap-2">
                                    <span>🍲</span> Aneka Daging
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <!-- Rendang Sapi (Checked) -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300" alt="Rendang Sapi" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Rendang Sapi</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="3" checked class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Empal Gepuk -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=300" alt="Empal Gepuk" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Empal Gepuk</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="5" class="hidden lauk-checkbox">
                                    </div>
                                </div>
                            </div>

                            <!-- Category: Aneka Sayur -->
                            <div class="space-y-2.5">
                                <h3 class="text-xs font-bold font-serif text-gray-800 flex items-center gap-2">
                                    <span>🥬</span> Aneka Sayur
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <!-- Tumis Buncis (Checked) -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&q=80&w=300" alt="Tumis Buncis" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Tumis Buncis</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="6" checked class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Capcay -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=300" alt="Capcay" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Capcay</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="7" class="hidden lauk-checkbox">
                                    </div>

                                    <!-- Urap Sayur -->
                                    <div onclick="togglePrasmananLauk(this)" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                                            <img src="https://images.unsplash.com/photo-1543339308-43e59d6b73a6?auto=format&fit=crop&q=80&w=300" alt="Urap Sayur" class="w-full h-full object-cover">
                                        </div>
                                        <div class="flex items-center justify-between px-1 pb-0.5">
                                            <span class="text-xs font-bold text-gray-900">Urap Sayur</span>
                                            <div class="check-box-icon w-4.5 h-4.5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                                        </div>
                                        <input type="checkbox" name="lauk_ids[]" value="8" class="hidden lauk-checkbox">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Standard Menu Banner -->
                        <div class="p-5 bg-[#EBF5E8]/80 rounded-2xl border border-[#D2E6CE] flex items-start gap-3.5 shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold text-brand-green shrink-0 mt-0.5 text-xs">
                                ℹ️
                            </div>
                            <div class="space-y-1 text-xs text-gray-700">
                                <h4 class="font-bold text-gray-900 text-sm font-serif">Informasi Menu Standar</h4>
                                <p class="leading-relaxed font-light">
                                    Setiap paket prasmanan sudah termasuk: <strong class="font-bold text-gray-900">Nasi Putih</strong>, <strong class="font-bold text-gray-900">Kerupuk</strong>, <strong class="font-bold text-gray-900">Sambal khas Rasaci</strong>, dan <strong class="font-bold text-gray-900">Dessert (Buah Potong/Pudding)</strong>. Peralatan saji, alat makan standar, dan tenaga waiter sudah termasuk dalam paket.
                                </p>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Sticky Sidebar (Span 4) -->
                    <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                        <div class="bg-white rounded-3xl overflow-hidden ambient-shadow border border-[#E5E5DC] p-5 space-y-5">
                            <div>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">MULAI DARI</span>
                                <div class="flex items-baseline gap-1">
                                    <span id="sidebarPriceLabel" class="text-2xl font-extrabold text-gray-900 font-serif">Rp 65.000</span>
                                    <span class="text-xs text-gray-500 font-light">/ pax</span>
                                </div>
                            </div>

                            <form id="prasmananOrderForm" onsubmit="submitDetailOrder(event)" class="space-y-4">
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
                                        <span class="text-[10px] text-gray-400 font-normal">Min. 20 pax</span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <button type="button" onclick="decrementPax()" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">-</button>
                                        <input type="number" id="detailJumlahPax" name="jumlah_pax" min="20" value="20" required oninput="calculateDetailPrice()" class="flex-1 text-center font-bold text-base bg-white border border-gray-200 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2D5A27]">
                                        <button type="button" onclick="incrementPax()" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">+</button>
                                    </div>
                                </div>

                                <!-- Price Breakdown -->
                                <div class="pt-3 border-t border-gray-100 space-y-2 text-xs">
                                    <div class="flex justify-between text-gray-600 font-light">
                                        <span>Harga per pax</span>
                                        <span id="summaryHargaPerPax">Rp 65.000</span>
                                    </div>
                                    <div class="flex justify-between text-gray-600 font-light">
                                        <span>Biaya Layanan</span>
                                        <span class="text-green-700 font-medium">Gratis</span>
                                    </div>
                                    <div class="border-t border-gray-200 pt-2.5 flex justify-between items-center">
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
                            <div class="w-8 h-8 rounded-full bg-[#2D5A27]/10 text-brand-green flex items-center justify-center text-sm shrink-0">
                                💬
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-gray-900">Konsultasi Menu Corporate?</h4>
                                <a href="https://wa.me/6281234567890?text=Halo%20RASACI%20Catering,%20saya%20tertarik%20mengenai%20paket%20Prasmanan" target="_blank" class="text-[#2D5A27] font-semibold text-[11px] hover:underline inline-flex items-center gap-1">
                                    Chat via Whatsapp &gt;
                                </a>
                            </div>
                        </div>
                    </aside>

                </div>

            @else
                <!-- ================= NASI KOTAK / TUMPENG DETAIL PAGE ================= -->
                
                <!-- Hero Bento Section (Compact Bento Grid with Overlaid Card & 2 Stacked Right Photos) -->
                <section class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-8">
                    <!-- Left Main Image with Overlaid Frosted Card (Span 7) -->
                    <div class="lg:col-span-7 relative h-[220px] sm:h-[250px] lg:h-[270px] overflow-hidden rounded-3xl ambient-shadow">
                        <img src="{{ $heroImage }}" alt="Paket {{ $paket->nm_paket }}" class="w-full h-full object-cover">
                        <!-- Frosted Headline Card Overlaid on Image -->
                        <div class="absolute bottom-4 left-4 right-4 sm:right-auto max-w-sm bg-[#EAEFE2]/95 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/80 z-20">
                            <span class="text-[9px] font-bold text-[#4F6B38] uppercase tracking-widest block mb-0.5">EKSKLUSIF NUSANTARA</span>
                            <h1 class="text-xl sm:text-2xl font-bold font-serif text-gray-900 mb-1 leading-tight">Paket {{ $paket->nm_paket }}</h1>
                            <p class="text-xs text-gray-700 font-light leading-relaxed">
                                {{ $paketDeskripsi }}
                            </p>
                        </div>
                    </div>

                    <!-- Right Column (Span 5) - 2 Stacked Images -->
                    <div class="lg:col-span-5 flex flex-col gap-3">
                        <div class="overflow-hidden rounded-2xl ambient-shadow h-[105px] sm:h-[120px] lg:h-[130px]">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=600" alt="Nasi Kotak Spread" class="w-full h-full object-cover">
                        </div>
                        <div class="overflow-hidden rounded-2xl ambient-shadow flex-1 min-h-[105px]">
                            <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=600" alt="Corporate Feast" class="w-full h-full object-cover">
                        </div>
                    </div>
                </section>

                <!-- Two Column Layout: Lauk Customization Grid + Sticky Sidebar -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                    
                    <!-- Left Column: Customization Configurator (Span 8) -->
                    <div class="lg:col-span-8 space-y-6">
                        
                        <!-- Package Title & Description Header Card -->
                        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] ambient-shadow space-y-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full bg-[#2D5A27] text-white text-[10px] font-bold uppercase tracking-wider">PAKET TERPILIH</span>
                                <h2 class="text-xl sm:text-2xl font-bold font-serif text-gray-900">Paket {{ $paket->nm_paket }}</h2>
                            </div>
                            <p class="text-xs text-gray-600 font-light leading-relaxed">
                                {{ $paketDeskripsi }}
                            </p>
                        </div>

                        <!-- Section Heading -->
                        <div class="flex items-center space-x-2 text-[#2D5A27]">
                            <span class="text-xl">🍴</span>
                            <h3 class="text-xl font-bold font-serif text-gray-900">Kustomisasi Lauk</h3>
                        </div>

                        <!-- Info Pill Banner -->
                        <div class="bg-[#EBF5E8] border border-[#D2E6CE] rounded-2xl p-3.5 flex items-center gap-3 text-brand-green text-xs shadow-sm">
                            <div class="w-5 h-5 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold shrink-0 text-brand-green text-[11px]">
                                ℹ️
                            </div>
                            <p class="text-[#2B4E25] font-medium text-xs leading-relaxed">
                                <span class="font-bold">Maksimal Custom Varian Lauk:</span> Pilih hingga {{ $paket->jumlah_lauk_pilihan }} varian lauk utama untuk set menu Paket {{ $paket->nm_paket }} Anda.
                            </p>
                        </div>

                        <!-- Category Header -->
                        <div class="space-y-4">
                            <div class="flex justify-between items-center border-b border-[#E5E5DC] pb-2">
                                <h3 class="text-sm font-bold font-serif text-gray-900">1. Lauk Utama</h3>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">MAKSIMAL {{ $paket->jumlah_lauk_pilihan }}</span>
                            </div>

                            <!-- 2-Column Lauk Cards Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                                @php
                                    $sampleLauks = [
                                        [
                                            'id' => 3,
                                            'name' => 'Rendang Daging Sapi',
                                            'desc' => 'Dimasak 8 jam dengan bumbu rempah otentik.',
                                            'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=200',
                                            'checked' => true
                                        ],
                                        [
                                            'id' => 1,
                                            'name' => 'Ayam Goreng Serundeng',
                                            'desc' => 'Ayam pejantan gurih dengan taburan kelapa.',
                                            'img' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=200',
                                            'checked' => true
                                        ],
                                        [
                                            'id' => 5,
                                            'name' => 'Empal Gepuk',
                                            'desc' => 'Daging empuk dengan rasa manis gurih meresap.',
                                            'img' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=200',
                                            'checked' => false
                                        ],
                                        [
                                            'id' => 17,
                                            'name' => 'Ikan Bakar Rica',
                                            'desc' => 'Fillet ikan kakap segar dengan sambal rica pedas.',
                                            'img' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&q=80&w=200',
                                            'checked' => false
                                        ]
                                    ];

                                    if(isset($lauks) && $lauks->count() > 0) {
                                        $dbLauks = [];
                                        foreach($lauks->take(4) as $idx => $l) {
                                            $lName = strtolower($l->nama_lauk);
                                            $img = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=200';
                                            if (str_contains($lName, 'ayam')) $img = 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=200';
                                            elseif (str_contains($lName, 'empal')) $img = 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=200';
                                            elseif (str_contains($lName, 'ikan')) $img = 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?auto=format&fit=crop&q=80&w=200';
                                            
                                            $dbLauks[] = [
                                                'id' => $l->id,
                                                'name' => $l->nama_lauk,
                                                'desc' => !empty($l->keterangan) ? $l->keterangan : 'Pilihan lauk Nusantara dengan cita rasa khas gurih.',
                                                'img' => $img,
                                                'checked' => $idx < $paket->jumlah_lauk_pilihan
                                            ];
                                        }
                                        if (count($dbLauks) >= 2) $sampleLauks = $dbLauks;
                                    }
                                @endphp

                                @foreach($sampleLauks as $lItem)
                                    <div onclick="toggleLaukCard(this, {{ $paket->jumlah_lauk_pilihan }})" 
                                         data-lauk-id="{{ $lItem['id'] }}"
                                         class="lauk-card p-3 bg-white rounded-2xl border @if($lItem['checked']) active-lauk-card border-[#2D5A27] @else border-gray-200 @endif relative shadow-sm hover:shadow-md transition-all cursor-pointer select-none flex items-center gap-3">
                                        
                                        <input type="checkbox" name="lauk_ids[]" value="{{ $lItem['id'] }}" @if($lItem['checked']) checked @endif class="lauk-checkbox hidden">
                                        
                                        <img src="{{ $lItem['img'] }}" alt="{{ $lItem['name'] }}" class="w-14 h-14 object-cover rounded-xl shrink-0">

                                        <div class="flex-1 min-w-0 pr-6">
                                            <h4 class="font-bold text-gray-900 text-xs sm:text-sm mb-0.5 truncate">{{ $lItem['name'] }}</h4>
                                            <p class="text-[11px] text-gray-500 font-light leading-relaxed line-clamp-2">
                                                {{ $lItem['desc'] }}
                                            </p>
                                        </div>

                                        <div class="absolute top-3.5 right-3.5 check-indicator @if(!$lItem['checked']) hidden @endif bg-[#2D5A27] text-white rounded-md w-4.5 h-4.5 flex items-center justify-center text-[10px] font-bold">
                                            ✓
                                        </div>
                                        <div class="absolute top-3.5 right-3.5 box-indicator @if($lItem['checked']) hidden @endif border border-gray-300 w-4.5 h-4.5 rounded-md bg-white"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Standard Menu Info Banner -->
                        <div class="p-5 bg-[#EBF5E8]/70 rounded-2xl border border-[#D2E6CE] flex items-start gap-3.5 shadow-sm">
                            <div class="w-6 h-6 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold text-brand-green shrink-0 mt-0.5 text-xs">
                                ℹ️
                            </div>
                            <div class="space-y-2">
                                <h4 class="font-bold text-gray-900 text-xs sm:text-sm font-serif">Informasi Menu Standar Paket {{ $paket->nm_paket }}</h4>
                                <p class="text-xs text-gray-600 font-light leading-relaxed">
                                    Setiap paket {{ strtolower($paket->nm_paket) }} sudah termasuk <strong class="font-bold text-gray-800">Sayuran (Tumis Buncis Jagung Muda)</strong>, <strong class="font-bold text-gray-800">Sambal khas Rasaci</strong>, dan <strong class="font-bold text-gray-800">Kentang Balado/Cabai</strong>.
                                </p>
                                <div class="flex flex-wrap gap-2 pt-0.5">
                                    <span class="px-3 py-0.5 bg-[#DCECD8] text-[#2D5A27] text-[10px] font-semibold rounded-full">Sayuran</span>
                                    <span class="px-3 py-0.5 bg-[#DCECD8] text-[#2D5A27] text-[10px] font-semibold rounded-full">Sambal</span>
                                    <span class="px-3 py-0.5 bg-[#DCECD8] text-[#2D5A27] text-[10px] font-semibold rounded-full">Kentang Balado</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column: Sticky Booking Summary -->
                    <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
                        <div class="bg-white rounded-3xl overflow-hidden ambient-shadow border border-[#E5E5DC]">
                            <!-- Top Dark Green Header Card -->
                            <div class="bg-[#2D5A27] p-5 text-white">
                                <span class="text-[10px] font-light tracking-wide block mb-0.5 text-gray-200">Mulai Dari</span>
                                <div class="flex items-baseline gap-1">
                                    <span id="sidebarPriceLabel" class="text-2xl font-extrabold tracking-tight font-serif">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                                    <span class="text-xs font-light text-gray-200">/ pax</span>
                                </div>
                            </div>

                            <div class="p-5 space-y-5 bg-[#FAF9F5]/40">
                                <form id="detailOrderForm" onsubmit="submitDetailOrder(event)" class="space-y-4">
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
                                            <button type="button" onclick="decrementPax()" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">-</button>
                                            <input type="number" id="detailJumlahPax" name="jumlah_pax" min="10" value="20" required oninput="calculateDetailPrice()" class="flex-1 text-center font-bold text-base bg-white border border-gray-200 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2D5A27]">
                                            <button type="button" onclick="incrementPax()" class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer text-base">+</button>
                                        </div>
                                        <p class="text-[10px] text-gray-400 font-light text-center italic">*Minimal pemesanan 10 pax</p>
                                    </div>

                                    <div class="pt-3 border-t border-[#E5E5DC] space-y-2">
                                        <div class="flex justify-between text-xs text-gray-600 font-light">
                                            <span>Harga Dasar</span>
                                            <span id="summaryHargaPerPax">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="flex justify-between text-xs text-gray-600 font-light">
                                            <span>Subtotal</span>
                                            <span id="detailSubtotal">Rp {{ number_format($hargaAwal * 20, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="border-t border-dashed border-gray-300 pt-2.5 flex justify-between items-center">
                                            <span class="text-xs font-bold text-gray-900">Total Estimasi</span>
                                            <span id="detailTotal" class="text-base font-extrabold text-[#2D5A27]">Rp {{ number_format($hargaAwal * 20, 0, ',', '.') }}</span>
                                        </div>
                                    </div>

                                    <div id="detailErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                                        <p id="detailErrorText" class="text-[11px] text-red-700 font-medium"></p>
                                    </div>

                                    <button type="submit" id="detailSubmitBtn" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs uppercase tracking-wider">
                                        <span>Pesan Sekarang</span>
                                        <div id="detailSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                    </button>

                                    <p class="text-[9.5px] text-gray-400 font-light text-center leading-tight">
                                        Harga dapat berubah sesuai dengan pilihan menu premium yang ditambahkan.
                                    </p>
                                </form>
                            </div>
                        </div>

                        <!-- Help Box (WhatsApp) -->
                        <div class="p-4 bg-[#EBF5E8] border border-[#D2E6CE] rounded-2xl flex items-center gap-3 shadow-sm">
                            <div class="w-8 h-8 rounded-full bg-[#2D5A27]/10 text-brand-green flex items-center justify-center text-sm shrink-0">
                                🎧
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-gray-900">Butuh Bantuan?</h4>
                                <p class="text-[10px] text-gray-500 font-light">Konsultasi menu khusus corporate?</p>
                                <a href="https://wa.me/6281234567890?text=Halo%20RASACI%20Catering,%20saya%20tertarik%20mengenai%20paket%20Nasi%20Kotak" target="_blank" class="text-[#2D5A27] font-semibold text-[11px] hover:underline inline-flex items-center gap-1 mt-0.5">
                                    Chat via WhatsApp &gt;
                                </a>
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
            let currentUnitPrice = {{ $hargaAwal }};
            let currentMaxLauk = {{ $paket->jumlah_lauk_pilihan }};
            let selectedLaukIds = [3, 1];

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
                    icon.className = "check-box-icon w-4.5 h-4.5 rounded-md border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold";
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
                    icon.className = "check-box-icon w-4.5 h-4.5 rounded-md bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold";
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
                    card.classList.remove('active-lauk-card', 'border-[#2D5A27]');
                    card.classList.add('border-gray-200');
                    if (checkIndicator) checkIndicator.classList.add('hidden');
                    if (boxIndicator) boxIndicator.classList.remove('hidden');
                    selectedLaukIds = selectedLaukIds.filter(id => id !== Number(checkbox.value));
                } else {
                    if (selectedLaukIds.length >= limit) {
                        alert(`Anda hanya boleh memilih maksimal ${limit} lauk untuk paket ini.`);
                        return;
                    }
                    checkbox.checked = true;
                    card.classList.add('active-lauk-card', 'border-[#2D5A27]');
                    card.classList.remove('border-gray-200');
                    if (checkIndicator) checkIndicator.classList.remove('hidden');
                    if (boxIndicator) boxIndicator.classList.add('hidden');
                    selectedLaukIds.push(Number(checkbox.value));
                }
            }

            // Increment / Decrement
            function incrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const step = 10;
                input.value = parseInt(input.value) + step;
                calculateDetailPrice();
            }

            function decrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const min = {{ $minPax }};
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
                document.getElementById('errorBanner').classList.add('hidden');

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
