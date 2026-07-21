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
                <h3 id="label-ayam-title" class="text-xs font-bold font-serif text-gray-800 flex items-center gap-2">
                    <span>🍴</span> Aneka Ayam (Pilih 1)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Ayam Goreng (Checked by default) -->
                    <div onclick="selectPrasmananLauk(this, 'ayam')" data-category="ayam" data-lauk-id="1" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=300" alt="Ayam Goreng" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Ayam Goreng</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                        </div>
                        <input type="checkbox" name="lauk_ayam[]" value="1" checked class="hidden lauk-input">
                    </div>

                    <!-- Ayam Bakar -->
                    <div onclick="selectPrasmananLauk(this, 'ayam')" data-category="ayam" data-lauk-id="2" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&q=80&w=300" alt="Ayam Bakar" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Ayam Bakar</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                        </div>
                        <input type="checkbox" name="lauk_ayam[]" value="2" class="hidden lauk-input">
                    </div>

                    <!-- Sate Ayam -->
                    <div onclick="selectPrasmananLauk(this, 'ayam')" data-category="ayam" data-lauk-id="4" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?auto=format&fit=crop&q=80&w=300" alt="Sate Ayam" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Sate Ayam</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                        </div>
                        <input type="checkbox" name="lauk_ayam[]" value="4" class="hidden lauk-input">
                    </div>
                </div>
            </div>

            <!-- Category: Aneka Daging -->
            <div class="space-y-2.5">
                <h3 id="label-daging-title" class="text-xs font-bold font-serif text-gray-800 flex items-center gap-2">
                    <span>🍲</span> Aneka Daging (Pilih 1)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Rendang Sapi (Checked by default) -->
                    <div onclick="selectPrasmananLauk(this, 'daging')" data-category="daging" data-lauk-id="3" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300" alt="Rendang Sapi" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Rendang Sapi</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                        </div>
                        <input type="checkbox" name="lauk_daging[]" value="3" checked class="hidden lauk-input">
                    </div>

                    <!-- Empal Gepuk -->
                    <div onclick="selectPrasmananLauk(this, 'daging')" data-category="daging" data-lauk-id="5" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=300" alt="Empal Gepuk" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Empal Gepuk</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                        </div>
                        <input type="checkbox" name="lauk_daging[]" value="5" class="hidden lauk-input">
                    </div>
                </div>
            </div>

            <!-- Category: Aneka Sayur -->
            <div class="space-y-2.5">
                <h3 id="label-sayur-title" class="text-xs font-bold font-serif text-gray-800 flex items-center gap-2">
                    <span>🥬</span> Aneka Sayur (Pilih 1)
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Tumis Buncis (Checked by default) -->
                    <div onclick="selectPrasmananLauk(this, 'sayur')" data-category="sayur" data-lauk-id="6" class="prasmanan-lauk-card active-card bg-white rounded-2xl border-2 border-[#2D5A27] overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&q=80&w=300" alt="Tumis Buncis" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Tumis Buncis</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full bg-[#2D5A27] text-white flex items-center justify-center text-[10px] font-bold">✓</div>
                        </div>
                        <input type="checkbox" name="lauk_sayur[]" value="6" checked class="hidden lauk-input">
                    </div>

                    <!-- Capcay -->
                    <div onclick="selectPrasmananLauk(this, 'sayur')" data-category="sayur" data-lauk-id="7" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&q=80&w=300" alt="Capcay" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Capcay</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                        </div>
                        <input type="checkbox" name="lauk_sayur[]" value="7" class="hidden lauk-input">
                    </div>

                    <!-- Urap Sayur -->
                    <div onclick="selectPrasmananLauk(this, 'sayur')" data-category="sayur" data-lauk-id="8" class="prasmanan-lauk-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative p-2">
                        <div class="h-20 rounded-xl overflow-hidden mb-1.5 relative">
                            <img src="https://images.unsplash.com/photo-1543339308-43e59d6b73a6?auto=format&fit=crop&q=80&w=300" alt="Urap Sayur" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1 pb-0.5">
                            <span class="text-xs font-bold text-gray-900">Urap Sayur</span>
                            <div class="check-box-icon w-4.5 h-4.5 rounded-full border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold"></div>
                        </div>
                        <input type="checkbox" name="lauk_sayur[]" value="8" class="hidden lauk-input">
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

        <!-- 3. Pilihan Gubukan (Opsional) Section -->
        <div class="space-y-4 pt-2">
            <div class="flex items-center space-x-3">
                <div class="w-7 h-7 rounded-full bg-[#3B420C] text-white font-serif font-bold flex items-center justify-center text-xs shrink-0">
                    3
                </div>
                <h2 class="text-xl font-bold font-serif text-gray-900">Pilihan Gubukan (Opsional)</h2>
            </div>
            <p class="text-xs text-gray-500 font-light leading-relaxed">
                Tambahkan menu gubukan favorit untuk melengkapi acara Anda. Pilihan ini bersifat opsional dan dapat dipilih lebih dari satu. <strong class="text-[#2D5A27]">(Minimal pemesanan Gubukan adalah 100 porsi)</strong>.
            </p>

            @php
                $gubukanItems = [
                    ['id' => 1, 'name' => 'Bakso', 'harga' => 15000, 'image' => 'https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&q=80&w=400'],
                    ['id' => 2, 'name' => 'Batagor', 'harga' => 10000, 'image' => 'https://images.unsplash.com/photo-1541544741938-0af808871cc0?auto=format&fit=crop&q=80&w=400'],
                    ['id' => 3, 'name' => 'Empek-empek', 'harga' => 10000, 'image' => 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?auto=format&fit=crop&q=80&w=400'],
                    ['id' => 4, 'name' => 'Zuppa Soup', 'harga' => 15000, 'image' => 'https://images.unsplash.com/photo-1547592166-23ac45744acd?auto=format&fit=crop&q=80&w=400'],
                    ['id' => 5, 'name' => 'Dimsum', 'harga' => 15000, 'image' => 'https://images.unsplash.com/photo-1496116218417-1a781b1c416c?auto=format&fit=crop&q=80&w=400'],
                ];
            @endphp

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
                @foreach($gubukanItems as $item)
                    @php
                        $dbGubukan = isset($gubukans) ? ($gubukans->firstWhere('nama_gubukan', $item['name']) ?? $gubukans->firstWhere('id', $item['id'])) : null;
                        $gubukanId = $dbGubukan ? $dbGubukan->id : $item['id'];
                    @endphp
                    <div onclick="togglePrasmananGubukan(this)" data-gubukan-id="{{ $gubukanId }}" class="prasmanan-gubukan-card bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none p-2 relative">
                        <div class="h-28 sm:h-32 rounded-xl overflow-hidden mb-2 relative">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div class="flex items-center justify-between px-1.5 pb-1">
                            <div class="flex flex-col">
                                <span class="text-xs font-bold text-gray-900">{{ $item['name'] }}</span>
                                <span class="text-[10px] text-gray-500 font-medium">Rp {{ number_format($item['harga'], 0, ',', '.') }}</span>
                            </div>
                            <div class="gubukan-checkbox-icon w-4.5 h-4.5 rounded border border-gray-300 bg-white flex items-center justify-center text-[10px] font-bold">
                                <input type="checkbox" name="gubukan_ids[]" value="{{ $gubukanId }}" class="hidden gubukan-input" onchange="event.stopPropagation()">
                            </div>
                        </div>
                    </div>
                @endforeach
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
                        <span id="summaryHargaPerPax">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Subtotal Paket</span>
                        <span id="detailSubtotal">Rp {{ number_format($hargaAwal * 20, 0, ',', '.') }}</span>
                    </div>
                    <div id="summaryGubukanRow" class="hidden flex justify-between text-gray-600 font-light">
                        <span>Tambahan Gubukan</span>
                        <span id="summaryGubukanValue" class="text-gray-900 font-medium">Rp 0</span>
                    </div>
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Biaya Layanan</span>
                        <span class="text-green-700 font-medium">Gratis</span>
                    </div>
                    <div class="border-t border-gray-200 pt-2.5 flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-900">Total Estimasi</span>
                        <span id="detailTotal" class="text-base font-extrabold text-[#2D5A27]">Rp {{ number_format($hargaAwal * 20, 0, ',', '.') }}</span>
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
