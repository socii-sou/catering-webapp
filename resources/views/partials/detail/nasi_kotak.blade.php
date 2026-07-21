<!-- ================= NASI KOTAK DETAIL PAGE ================= -->

<!-- Hero Bento Section (Large Main Image with Frosted Card & 2 Right Stacked Images) -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-4 mb-8">
    <!-- Left Main Hero Image with Overlaid Frosted Card (Span 7) -->
    <div class="lg:col-span-7 relative h-[250px] sm:h-[280px] lg:h-full overflow-hidden rounded-3xl ambient-shadow">
        <img src="{{ $heroImage }}" alt="Paket {{ $paket->nm_paket }}" class="absolute inset-0 w-full h-full object-cover">

        <!-- Frosted Headline Card Overlaid on Image -->
        <div class="absolute bottom-4 left-4 right-4 sm:right-auto max-w-md bg-[#EAEFE2]/95 backdrop-blur-md p-4 sm:p-5 rounded-2xl shadow-xl border border-white/80 z-20">
            <span class="px-2.5 py-0.5 rounded-full bg-[#3B420C] text-white text-[9px] font-bold uppercase tracking-widest inline-block mb-1.5">EKSKLUSIF NUSANTARA</span>
            <h1 class="text-xl sm:text-2xl font-bold font-serif text-gray-900 mb-1 leading-tight">Paket {{ $paket->nm_paket }}</h1>
            <p class="text-xs text-gray-700 font-light leading-relaxed">
                {{ $paketDeskripsi }}
            </p>
        </div>
    </div>

    <!-- Right Column (Span 5) - 2 Stacked Images -->
    <div class="lg:col-span-5 flex flex-col gap-3">
        <div class="overflow-hidden rounded-2xl ambient-shadow h-[120px] sm:h-[135px] lg:h-[145px]">
            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=600" alt="Nasi Kotak Spread" class="w-full h-full object-cover">
        </div>
        <div class="overflow-hidden rounded-2xl ambient-shadow h-[120px] sm:h-[135px] lg:h-[145px]">
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
                    Setiap paket {{ strtolower($paket->nm_paket) }} sudah termasuk <strong class="font-bold text-gray-800">Sayuran (Tumis Buncis Jagung Muda)</strong>, <strong class="font-bold text-gray-800">Sambal khas Rasaci</strong>, and <strong class="font-bold text-gray-800">Kentang Balado/Cabai</strong>.
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
