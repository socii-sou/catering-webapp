@extends('layouts.app')

@section('title', $paket->nm_paket . ' - RASACI Catering')
@section('meta-description', 'Kustomisasi paket catering ' . $paket->nm_paket . ' Anda di RASACI Catering. Pilihlah lauk pilihan terbaik untuk acara Anda.')

@section('styles')
        <style>
            .active-lauk-card {
                border-color: #2D5A27 !important;
                background-color: rgba(45, 90, 39, 0.03) !important;
            }
        </style>
@endsection

@section('content')
        @php
            // Single Hero Image mapping
            $heroImage = asset('images/nasi_kotak.jpg');

            if (str_contains(strtolower($paket->nm_paket), 'prasmanan')) {
                $heroImage = asset('images/prasmanan.jpg');
            } elseif (str_contains(strtolower($paket->nm_paket), 'tumpeng')) {
                $heroImage = asset('images/tumpeng.jpg');
            }

            $paketDeskripsi = !empty($paket->deskripsi) ? $paket->deskripsi : 'Solusi praktis untuk rapat kantor, seminar, atau konsumsi panitia dengan cita rasa Nusantara yang konsisten dan higienis.';
            if (!str_contains($paketDeskripsi, 'dan higienis')) {
                $paketDeskripsi = rtrim($paketDeskripsi, '.') . ' dan higienis.';
            }
        @endphp

        <!-- Main Content Area -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">

            <!-- Single Hero Image with Floating Compact Headline Overlay Card (Bottom-Right) -->
            <section class="relative w-full h-[360px] sm:h-[440px] lg:h-[480px] overflow-hidden rounded-3xl ambient-shadow mb-16">
                <!-- Hero Photo -->
                <img src="{{ $heroImage }}" alt="{{ $paket->nm_paket }}" class="w-full h-full object-cover">
                
                <!-- Bottom gradient overlay for visual depth -->
                <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-transparent pointer-events-none"></div>

                <!-- Floating Headline Card (Bottom-Right, Compact Width, Rounded Corners) -->
                <div class="absolute bottom-6 right-6 left-6 sm:left-auto max-w-xs sm:max-w-sm bg-[#EAEFE2]/95 backdrop-blur-md p-5 sm:p-6 rounded-3xl shadow-2xl border border-white/80 z-20">
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
                        <h2 class="text-2xl font-bold font-serif text-gray-900">Kustomisasi Lauk</h2>
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
                        // Group lauks by category
                        $groupedLauks = $lauks->groupBy(function($lauk) {
                            return $lauk->kategoriLauk?->nama_kategori ?? 'Lauk Utama';
                        });
                    @endphp

                    @php $categoryIndex = 1; @endphp
                    @foreach($groupedLauks as $categoryName => $lauksInGroup)
                        <!-- Category Section -->
                        <div class="space-y-4">
                            <!-- Category Header -->
                            <div class="flex justify-between items-center border-b border-[#E5E5DC] pb-2">
                                <h3 class="text-base font-bold font-serif text-gray-900">{{ $categoryIndex }}. {{ $categoryName }}</h3>
                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">MAKSIMAL {{ $paket->jumlah_lauk_pilihan }}</span>
                            </div>

                            <!-- Lauk Option Grid (Matching Mockup with Thumbnails) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($lauksInGroup as $index => $lauk)
                                    @php
                                        $lName = strtolower($lauk->nama_lauk);
                                        
                                        // Image thumbnail mappings for lauk cards
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

                                        // Auto pre-check first items to match design mockup
                                        $isPrechecked = false;
                                        if ($loop->parent->first && $index < $paket->jumlah_lauk_pilihan && ($lName === 'rendang daging sapi' || $lName === 'ayam goreng serundeng' || $lName === 'rendang sapi' || $lName === 'ayam goreng' || $index < 2)) {
                                            $isPrechecked = true;
                                        }
                                    @endphp

                                    <!-- Card Lauk (Matching Mockup Layout) -->
                                    <div onclick="toggleLaukCard(this, {{ $paket->jumlah_lauk_pilihan }})" 
                                         data-lauk-id="{{ $lauk->id }}"
                                         class="lauk-card p-4 bg-[#FDFDF6] rounded-2xl border border-[#E5E5DC] relative ambient-shadow hover:shadow-md transition-all cursor-pointer select-none flex items-center gap-4 @if($isPrechecked) active-lauk-card @endif">
                                        
                                        <input type="checkbox" name="lauk_ids[]" value="{{ $lauk->id }}" @if($isPrechecked) checked @endif class="lauk-checkbox hidden">
                                        
                                        <!-- Thumbnail Image -->
                                        <img src="{{ $thumbUrl }}" alt="{{ $lauk->nama_lauk }}" class="w-16 h-16 sm:w-20 sm:h-20 object-cover rounded-xl shrink-0">

                                        <!-- Title and Description -->
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

                                        <!-- Checkbox State Indicator (Top Right) -->
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
                        <!-- Card Header -->
                        <div class="bg-[#2D5A27] p-6 text-white">
                            <span class="text-[11px] font-light tracking-wide block mb-1 text-gray-200">Mulai Dari</span>
                            <div class="flex items-baseline gap-1">
                                <span class="text-2xl font-extrabold tracking-tight">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }}</span>
                                <span class="text-xs font-light text-gray-200">/ pax</span>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6 space-y-6 bg-[#FAF9F5]/40">
                            
                            <!-- Form -->
                            <form id="detailOrderForm" onsubmit="submitDetailOrder(event)" class="space-y-5">
                                @csrf
                                <input type="hidden" name="items[0][paket_id]" value="{{ $paket->id }}">
                                <input type="hidden" name="items[0][jml_paket]" id="detailInputJmlPaket" value="20">

                                <!-- Date Picker -->
                                <div class="space-y-1.5">
                                    <label for="detailTglAcara" class="block text-[11px] font-semibold text-gray-700">Tanggal Pengiriman</label>
                                    <div class="relative">
                                        <input type="date" id="detailTglAcara" name="tgl_acara" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-white">
                                    </div>
                                </div>

                                <!-- Quantity Input -->
                                <div class="space-y-1.5">
                                    <label class="block text-[11px] font-semibold text-gray-700">Jumlah Pesanan (Pax)</label>
                                    <div class="flex items-center gap-3">
                                        <button type="button" onclick="decrementPax()" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer select-none text-base">-</button>
                                        <input type="number" id="detailJumlahPax" name="jumlah_pax" min="10" value="20" required oninput="calculateDetailPrice()" class="flex-1 text-center font-bold text-base bg-white border border-gray-200 py-1.5 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2D5A27]">
                                        <button type="button" onclick="incrementPax()" class="w-10 h-10 flex items-center justify-center rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-bold transition-colors cursor-pointer select-none text-base">+</button>
                                    </div>
                                    <p class="text-[10px] text-gray-400 font-light text-center italic">*Minimal pemesanan 10 pax</p>
                                </div>

                                <!-- Price Breakdown -->
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

                                <!-- Error Banner -->
                                <div id="detailErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                                    <p id="detailErrorText" class="text-[11px] text-red-700 font-medium"></p>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" id="detailSubmitBtn" class="w-full bg-[#2D5A27] hover:bg-[#22451E] text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs uppercase tracking-wider">
                                    <span>Pesan Sekarang</span>
                                    <div id="detailSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                                </button>
                            </form>
                            <p class="text-[10px] text-center text-gray-400 font-light leading-relaxed">
                                Harga dapat berubah sesuai dengan pilihan menu premium yang ditambahkan.
                            </p>
                        </div>
                    </div>

                    <!-- Help Card -->
                    <div class="p-5 bg-[#EBF5E8] border border-[#D2E6CE] rounded-2xl flex items-start gap-3">
                        <div class="w-9 h-9 rounded-full bg-[#2D5A27]/10 text-brand-green flex items-center justify-center text-lg shrink-0 mt-0.5">
                            🎧
                        </div>
                        <div class="space-y-1">
                            <h4 class="font-bold text-sm text-gray-900">Butuh Bantuan?</h4>
                            <p class="text-xs text-gray-600 font-light">Konsultasi menu khusus corporate?</p>
                            <a href="https://wa.me/6281234567890?text=Halo%20RASACI%20Catering,%20saya%20tertarik%20mengenai%20paket%20{{ urlencode($paket->nm_paket) }}" target="_blank" class="text-[#2D5A27] font-bold text-xs hover:underline inline-flex items-center gap-1 mt-1">
                                Chat via WhatsApp &rarr;
                            </a>
                        </div>
                    </div>
                </aside>

            </div>

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
            const pricePerPax = {{ $paket->harga_paket }};
            let selectedLaukIds = [];

            // Initialize pre-checked lauks
            document.addEventListener('DOMContentLoaded', () => {
                const checkedCheckboxes = document.querySelectorAll('.lauk-checkbox:checked');
                checkedCheckboxes.forEach(cb => {
                    selectedLaukIds.push(Number(cb.value));
                });
                calculateDetailPrice();
            });

            // Toggle lauk selection
            function toggleLaukCard(card, limit) {
                const checkbox = card.querySelector('.lauk-checkbox');
                const checkIndicator = card.querySelector('.check-indicator');
                const boxIndicator = card.querySelector('.box-indicator');

                if (checkbox.checked) {
                    // Uncheck
                    checkbox.checked = false;
                    card.classList.remove('active-lauk-card');
                    if (checkIndicator) checkIndicator.classList.add('hidden');
                    if (boxIndicator) boxIndicator.classList.remove('hidden');
                    selectedLaukIds = selectedLaukIds.filter(id => id !== Number(checkbox.value));
                } else {
                    // Check if selection reached limit
                    if (selectedLaukIds.length >= limit) {
                        alert(`Anda hanya boleh memilih maksimal ${limit} lauk untuk paket ini.`);
                        return;
                    }
                    // Check
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
                input.value = parseInt(input.value) + 10;
                calculateDetailPrice();
            }

            function decrementPax() {
                const input = document.getElementById('detailJumlahPax');
                const current = parseInt(input.value);
                if (current > 10) {
                    input.value = current - 10;
                    calculateDetailPrice();
                }
            }

            function calculateDetailPrice() {
                const paxInput = document.getElementById('detailJumlahPax');
                const inputJml = document.getElementById('detailInputJmlPaket');
                if (!paxInput) return;

                const pax = Number(paxInput.value) || 0;
                if (inputJml) inputJml.value = pax;

                const subtotal = pax * pricePerPax;
                const formatted = 'Rp ' + subtotal.toLocaleString('id-ID');

                document.getElementById('detailSubtotal').innerText = formatted;
                document.getElementById('detailTotal').innerText = formatted;
            }

            // AJAX submit order
            function submitDetailOrder(event) {
                event.preventDefault();

                // Check auth
                @guest
                    openLoginModal();
                    return;
                @endguest

                // Validate selected lauk count
                const limit = {{ $paket->jumlah_lauk_pilihan }};
                if (selectedLaukIds.length !== limit) {
                    showDetailError(`Silakan pilih tepat ${limit} lauk utama sebelum memesan.`);
                    return;
                }

                const paxInput = document.getElementById('detailJumlahPax').value;
                const tglAcara = document.getElementById('detailTglAcara').value;

                // Show spinner
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
