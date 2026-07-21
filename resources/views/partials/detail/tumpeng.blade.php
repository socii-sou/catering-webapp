<!-- ================= TUMPENG DETAIL PAGE (MATCHING NEW MOCKUP EXACTLY) ================= -->

<!-- Hero Bento Section (Large Main Image with Frosted Card & 2 Right Stacked Images) -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-8">
    <!-- Left Main Hero Image with Overlaid Frosted Card (Span 7) -->
    <div class="lg:col-span-7 relative h-[250px] sm:h-[280px] lg:h-full overflow-hidden rounded-3xl ambient-shadow">
        <img src="{{ $heroImage }}" alt="Nasi Tumpeng Nusantara" class="absolute inset-0 w-full h-full object-cover">

        <!-- Frosted Headline Card Overlaid on Image -->
        <div class="absolute bottom-4 left-4 right-4 sm:right-auto max-w-md bg-[#EAEFE2]/95 backdrop-blur-md p-4 sm:p-5 rounded-2xl shadow-xl border border-white/80 z-20">
            <div class="flex items-center gap-2 mb-1.5 flex-wrap">
                <span class="px-2.5 py-0.5 rounded-full bg-[#3B420C] text-white text-[9px] font-bold uppercase tracking-widest inline-block">EKSKLUSIF NUSANTARA</span>
                <span class="px-2.5 py-0.5 rounded-full bg-[#2D5A27] text-white text-[9px] font-bold uppercase tracking-widest inline-block">Porsi 15 - 20 Orang</span>
            </div>
            <h1 class="text-xl sm:text-2xl font-bold font-serif text-gray-900 mb-1 leading-tight">Nasi Tumpeng Nusantara</h1>
            <p class="text-xs text-gray-700 font-light leading-relaxed">
                Sajian ikonik porsi 15 - 20 orang untuk perayaan spesial, lengkap dengan nasi kuning kerucut dan lauk pilihan autentik.
            </p>
        </div>
    </div>

    <!-- Right Column (Span 5) - 2 Stacked Images -->
    <div class="lg:col-span-5 flex flex-col gap-3">
        <div class="overflow-hidden rounded-2xl ambient-shadow h-[120px] sm:h-[135px] lg:h-[145px]">
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=600" alt="Tumpeng Tampah Platter" class="w-full h-full object-cover">
        </div>
        <div class="overflow-hidden rounded-2xl ambient-shadow h-[120px] sm:h-[135px] lg:h-[145px]">
            <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=600" alt="Tumpeng Dining Setup" class="w-full h-full object-cover">
        </div>
    </div>
</section>

<!-- Two Column Layout: Main Content + Sticky Booking Sidebar -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

    <!-- Left Column: Configurator & Information (Span 8) -->
    <div class="lg:col-span-8 space-y-6">

        <!-- Informasi Menu Standar Banner (Top Box in Mockup) -->
        <div class="p-5 bg-[#F1F6EC] rounded-2xl border border-[#D5E5CD] flex items-start gap-4 shadow-sm">
            <div class="w-7 h-7 rounded-full bg-[#2D5A27]/10 flex items-center justify-center font-bold text-[#2D5A27] shrink-0 mt-0.5 text-xs">
                ℹ️
            </div>
            <div class="space-y-1.5">
                <h4 class="font-bold text-gray-900 text-sm sm:text-base font-serif">Informasi Menu Standar (Porsi 15 - 20 Orang)</h4>
                <p class="text-xs text-gray-700 font-light leading-relaxed">
                    Setiap 1 paket Tumpeng (porsi 15 - 20 orang) sudah termasuk <strong class="font-semibold text-gray-900">Nasi Kuning</strong>, <strong class="font-semibold text-gray-900">Perkedel</strong>, <strong class="font-semibold text-gray-900">Telur Dadar Rawis</strong>, <strong class="font-semibold text-gray-900">Orek Tempe</strong>, <strong class="font-semibold text-gray-900">Sambal Goreng Kentang Ati</strong>, dan <strong class="font-semibold text-gray-900">Sayuran</strong>.
                </p>
            </div>
        </div>

        <!-- Section Heading: Kustomisasi Tumpeng -->
        <div class="flex items-center space-x-2 text-[#2D5A27] pt-2">
            <span class="text-xl">🍴</span>
            <h2 class="text-xl font-bold font-serif text-gray-900">Kustomisasi Tumpeng</h2>
        </div>

        <!-- Sub-category: Protein Utama -->
        <div class="space-y-4">
            <div class="border-l-4 border-[#3B420C] pl-2.5">
                <h3 class="text-sm font-bold font-serif text-gray-900">Protein Utama</h3>
            </div>

            <!-- 2-Column Protein Utama Grid Cards (Matching mockup exact layout) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @php
                    $tumpengProteins = [
                        [
                            'id' => 1,
                            'name' => 'Ayam Goreng',
                            'img' => 'https://images.unsplash.com/photo-1604908176997-125f25cc6f3d?auto=format&fit=crop&q=80&w=400',
                            'checked' => true
                        ],
                        [
                            'id' => 2,
                            'name' => 'Ayam Bakar',
                            'img' => 'https://images.unsplash.com/photo-1598515214211-89d3c73ae83b?auto=format&fit=crop&q=80&w=400',
                            'checked' => false
                        ],
                        [
                            'id' => 5,
                            'name' => 'Empal Gepuk',
                            'img' => 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=400',
                            'checked' => false
                        ],
                        [
                            'id' => 3,
                            'name' => 'Rendang Sapi',
                            'img' => 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=400',
                            'checked' => false
                        ]
                    ];
                @endphp

                @foreach($tumpengProteins as $pItem)
                    <div onclick="selectTumpengProtein(this)"
                         data-lauk-id="{{ $pItem['id'] }}"
                         class="tumpeng-protein-card bg-white rounded-2xl border @if($pItem['checked']) border-2 border-[#2D5A27] active-card @else border-gray-200 @endif overflow-hidden shadow-sm hover:shadow-md transition-all cursor-pointer select-none relative flex flex-col">

                        <input type="radio" name="lauk_tumpeng_protein" value="{{ $pItem['id'] }}" @if($pItem['checked']) checked @endif class="hidden lauk-radio">

                        <!-- Full Image Top -->
                        <div class="h-32 sm:h-36 w-full overflow-hidden relative">
                            <img src="{{ $pItem['img'] }}" alt="{{ $pItem['name'] }}" class="w-full h-full object-cover">
                            <div class="check-box-icon absolute top-3 right-3 w-6 h-6 rounded-full @if($pItem['checked']) bg-[#2D5A27] text-white @else bg-white/90 border border-gray-300 text-transparent @endif flex items-center justify-center text-xs font-bold shadow-sm">
                                ✓
                            </div>
                        </div>

                        <!-- Card Footer Label -->
                        <div class="p-3.5 bg-white border-t border-gray-100 flex items-center justify-between">
                            <span class="font-bold text-gray-900 text-xs sm:text-sm">{{ $pItem['name'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Right Column: Sticky Booking Sidebar (Matching Tumpeng Mockup) -->
    <aside class="lg:col-span-4 lg:sticky lg:top-24 space-y-4">
        <div class="bg-white rounded-3xl overflow-hidden ambient-shadow border border-[#E5E5DC] p-5 space-y-5">
            <div>
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest block mb-1">MULAI DARI</span>
                <div class="flex items-baseline gap-1">
                    <span id="sidebarPriceLabel" class="text-2xl sm:text-3xl font-extrabold text-gray-900 font-serif">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                    <span class="text-xs text-gray-500 font-light">/ paket</span>
                </div>
            </div>

            <form id="tumpengOrderForm" onsubmit="submitDetailOrder(event)" class="space-y-4">
                @csrf
                <input type="hidden" name="items[0][paket_id]" value="{{ $paket->id }}">
                <input type="hidden" name="items[0][jml_paket]" id="tumpengInputJmlPaket" value="1">

                <!-- Delivery Date -->
                <div class="space-y-1.5">
                    <label for="detailTglAcara" class="block text-[11px] font-semibold text-gray-700">Delivery Date</label>
                    <input type="date" id="detailTglAcara" name="tgl_acara" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-[#F9FAF4]">
                </div>

                <!-- Quantity Stepper (Container matching mockup) -->
                <div class="space-y-1.5">
                    <div class="flex justify-between items-center text-[11px] font-semibold text-gray-700">
                        <span>Quantity (Paket Tumpeng)</span>
                        <span class="text-[10px] text-[#2D5A27] font-bold">15 - 20 orang / paket</span>
                    </div>
                    <div class="flex items-center justify-between bg-[#F4F7EE] border border-gray-200 rounded-xl p-1.5 px-3">
                        <button type="button" onclick="decrementPax()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white hover:bg-gray-100 text-gray-700 font-bold transition-colors cursor-pointer text-sm shadow-xs">-</button>
                        <input type="number" id="detailJumlahPax" name="jumlah_pax" min="1" value="1" required oninput="calculateDetailPrice()" class="w-16 text-center font-bold text-base bg-transparent border-none focus:outline-none">
                        <button type="button" onclick="incrementPax()" class="w-8 h-8 flex items-center justify-center rounded-lg bg-white hover:bg-gray-100 text-gray-700 font-bold transition-colors cursor-pointer text-sm shadow-xs">+</button>
                    </div>
                    <p class="text-[10px] text-gray-500 font-light text-center italic">*1 Paket Tumpeng disajikan untuk 15 - 20 porsi / orang</p>
                </div>

                <!-- Pricing Breakdown Card -->
                <div class="p-4 bg-[#F2F6ED] rounded-xl space-y-2.5 text-xs text-gray-700 border border-[#DEE9D7]">
                    <div class="flex justify-between font-light">
                        <span>Base Price</span>
                        <span id="summaryHargaPerPax">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-light">
                        <span>Subtotal</span>
                        <span id="detailSubtotal">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-dashed border-gray-300 pt-2 flex justify-between items-center">
                        <span class="font-bold text-gray-900 text-xs uppercase tracking-wide">TOTAL ESTIMATION</span>
                        <div class="text-right">
                            <span id="detailTotal" class="text-base font-extrabold text-gray-900 font-serif block">Rp {{ number_format($hargaAwal, 0, ',', '.') }}</span>
                            <span class="text-[9px] text-gray-400 italic font-light">Excl. Delivery</span>
                        </div>
                    </div>
                </div>

                <!-- Error Banner -->
                <div id="detailErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                    <p id="detailErrorText" class="text-[11px] text-red-700 font-medium"></p>
                </div>

                <!-- Submit Button with Shopping Cart Icon -->
                <button type="submit" id="detailSubmitBtn" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs">
                    <span>🛒</span>
                    <span>Pesan Sekarang</span>
                    <div id="detailSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                </button>

                <p class="text-[9.5px] text-gray-400 font-light text-center leading-tight">
                    Konfirmasi instan akan dikirimkan ke email Anda setelah pembayaran selesai.
                </p>
            </form>
        </div>
    </aside>

</div>

<script>
    function selectTumpengProtein(card) {
        document.querySelectorAll('.tumpeng-protein-card').forEach(c => {
            c.classList.remove('border-2', 'border-[#2D5A27]', 'active-card');
            c.classList.add('border-gray-200');

            const icon = c.querySelector('.check-box-icon');
            if (icon) {
                icon.className = "check-box-icon absolute top-3 right-3 w-6 h-6 rounded-full bg-white/90 border border-gray-300 text-transparent flex items-center justify-center text-xs font-bold shadow-sm";
            }

            const radio = c.querySelector('.lauk-radio');
            if (radio) radio.checked = false;
        });

        card.classList.add('border-2', 'border-[#2D5A27]', 'active-card');
        card.classList.remove('border-gray-200');

        const icon = card.querySelector('.check-box-icon');
        if (icon) {
            icon.className = "check-box-icon absolute top-3 right-3 w-6 h-6 rounded-full bg-[#2D5A27] text-white flex items-center justify-center text-xs font-bold shadow-sm";
        }

        const radio = card.querySelector('.lauk-radio');
        if (radio) {
            radio.checked = true;
            if (typeof selectedLaukIds !== 'undefined') {
                selectedLaukIds = [Number(radio.value)];
            }
        }
    }
</script>
