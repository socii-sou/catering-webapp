@extends('layouts.app')

@section('title', 'Detail Pengiriman - RASACI Catering')

@section('styles')
<!-- Leaflet.js CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #checkoutMap {
        z-index: 1;
    }
    .custom-pin-marker {
        position: relative;
        width: 32px;
        height: 42px;
    }
    .custom-pin-marker svg {
        filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.3));
    }
    @keyframes pulse-ring {
        0% {
            transform: scale(0.5);
            opacity: 1;
        }
        100% {
            transform: scale(1.8);
            opacity: 0;
        }
    }
    .pin-pulse {
        position: absolute;
        bottom: 2px;
        left: 50%;
        transform: translateX(-50%);
        width: 24px;
        height: 12px;
        background: rgba(45, 90, 39, 0.35);
        border-radius: 50%;
        animation: pulse-ring 1.5s cubic-bezier(0.215, 0.61, 0.355, 1) infinite;
    }
</style>
@endsection

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- STEPPER HEADER -->
    <div class="flex items-center justify-center max-w-xl mx-auto py-2">
        <div class="flex items-center space-x-8 w-full justify-between">
            <!-- Step 1 -->
            <a href="{{ route('paket.show', $paket->id) }}" class="flex items-center gap-2.5 text-xs font-medium text-gray-500 hover:text-gray-900 transition-colors">
                <div class="w-7 h-7 rounded-full border border-gray-300 bg-white flex items-center justify-center text-xs text-gray-600 font-bold">
                    1
                </div>
                <span class="hidden sm:inline">Pilih Paket</span>
            </a>

            <div class="flex-1 h-0.5 bg-[#2D5A27]"></div>

            <!-- Step 2 (Active) -->
            <div class="flex items-center gap-2.5 text-xs font-bold text-gray-900">
                <div class="w-7 h-7 rounded-full bg-[#3B420C] text-white flex items-center justify-center text-xs font-bold shadow-xs">
                    2
                </div>
                <span>Detail Pengiriman</span>
            </div>

            <div class="flex-1 h-0.5 bg-gray-200"></div>

            <!-- Step 3 -->
            <div class="flex items-center gap-2.5 text-xs font-medium text-gray-400">
                <div class="w-7 h-7 rounded-full border border-gray-200 bg-white flex items-center justify-center text-xs text-gray-400 font-bold">
                    3
                </div>
                <span class="hidden sm:inline">Konfirmasi</span>
            </div>
        </div>
    </div>

    @php
        $paketSubtotal = $paket->harga_paket * $jumlahPax;
        $gubukanSubtotal = $selectedGubukan ? ($selectedGubukan->harga_gubukan * $jumlahPax) : 0;
        $grandTotal = $paketSubtotal + $gubukanSubtotal;

        $heroImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300';
        if (str_contains(strtolower($paket->nm_paket), 'prasmanan')) {
            $heroImage = 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=300';
        } elseif (str_contains(strtolower($paket->nm_paket), 'tumpeng')) {
            $heroImage = 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?auto=format&fit=crop&q=80&w=300';
        }
    @endphp

    <!-- MAIN FORM & SIDEBAR GRID -->
    <form id="checkoutForm" onsubmit="submitCheckoutOrder(event)" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        @csrf

        <!-- LEFT COLUMN: FORM INPUTS (Span 7) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 1: Lokasi Pengiriman -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-5">
                <div class="flex items-center justify-between flex-wrap gap-2">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">📍</span>
                        <h2 class="text-xl font-bold font-serif text-gray-900">Lokasi Pengiriman</h2>
                    </div>
                    <span class="text-[11px] bg-[#EBF5E8] text-[#2D5A27] font-semibold px-3 py-1 rounded-full border border-[#D2E6CE]">
                        Peta Interaktif Google Maps Style
                    </span>
                </div>

                <div class="space-y-2">
                    <label for="alamat_pengiriman" class="block text-xs font-semibold text-gray-700">Alamat Lengkap Pengiriman</label>
                    <textarea id="alamat_pengiriman" name="alamat_pengiriman" required rows="3"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-[#F8F9F3] placeholder-gray-400 leading-relaxed"
                        placeholder="Detail alamat (nama jalan, nomor rumah, RT/RW, patokan)...">{{ old('alamat_pengiriman', auth()->user()->alamat ?? '') }}</textarea>
                </div>

                <!-- Interactive Map Section with Search & Geolocation Controls -->
                <div class="space-y-3">
                    <!-- Search Bar & Current Location Row -->
                    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-2.5">
                        <!-- Search Box Container with Dropdown Suggestions -->
                        <div class="relative flex-1">
                            <div class="relative flex items-center w-full">
                                <svg class="w-4 h-4 text-gray-400 absolute left-3.5 pointer-events-none shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <input type="text" id="mapSearchInput" onkeyup="handleSearchInputKey(event)"
                                    placeholder="Cari lokasi, jalan, perumahan di Jabodetabek..."
                                    class="w-full pl-10 pr-20 py-2.5 rounded-2xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-white shadow-2xs">
                                <button type="button" onclick="searchLocationOnMap()" class="absolute right-1.5 px-3.5 py-1.5 bg-[#2D5A27] hover:bg-[#21441D] text-white text-xs font-semibold rounded-xl transition-all cursor-pointer shadow-2xs">
                                    Cari
                                </button>
                            </div>
                            
                            <!-- Search Autocomplete Dropdown List -->
                            <div id="searchSuggestions" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-2xl shadow-xl z-30 max-h-64 overflow-y-auto divide-y divide-gray-100">
                            </div>
                        </div>

                        <!-- Current Location Button -->
                        <button type="button" onclick="getCurrentLocation()" class="px-4 py-2.5 bg-[#EBF5E8] hover:bg-[#DCECD8] text-[#2D5A27] font-semibold text-xs rounded-2xl border border-[#D2E6CE] flex items-center justify-center gap-2 transition-all cursor-pointer shrink-0 shadow-2xs">
                            <span class="text-sm">🎯</span>
                            <span>Lokasi Saat Ini</span>
                        </button>
                    </div>

                    <!-- Map Container with Status Overlay -->
                    <div class="relative rounded-2xl border border-gray-200 overflow-hidden shadow-xs">
                        <div id="checkoutMap" class="w-full h-64 sm:h-72"></div>
                        
                        <!-- Floating Live Status Badge -->
                        <div id="mapStatusOverlay" class="absolute bottom-3 left-3 right-3 z-10 bg-white/95 backdrop-blur-md px-3.5 py-2.5 rounded-2xl text-[11px] text-gray-700 font-medium border border-gray-200/90 shadow-md flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2 truncate">
                                <span class="text-sm shrink-0">📍</span>
                                <span id="mapStatusText" class="truncate">Klik peta atau geser pin untuk menentukan titik pengiriman.</span>
                            </div>
                            <div id="mapLoader" class="hidden w-4 h-4 border-2 border-[#2D5A27] border-t-transparent rounded-full animate-spin shrink-0"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Catatan Tambahan -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-4">
                <div class="flex items-center gap-2.5">
                    <span class="text-xl">💬</span>
                    <h2 class="text-xl font-bold font-serif text-gray-900">Catatan Tambahan</h2>
                </div>

                <div class="space-y-2">
                    <label for="catatan" class="block text-xs font-semibold text-gray-700">Instruksi Khusus (Opsional)</label>
                    <textarea id="catatan" name="catatan" rows="3"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-[#2D5A27] text-xs bg-[#F8F9F3] placeholder-gray-400 leading-relaxed min-h-[90px]"
                        placeholder="Contoh: Tidak pedas, kurangi minyak, atau petunjuk gerbang perumahan..."></textarea>
                </div>
            </div>

        </div>

        <!-- RIGHT COLUMN: STICKY RINGKASAN PESANAN (Span 5) -->
        <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-4">

            <div class="bg-white rounded-3xl border border-[#E5E5DC] p-6 shadow-xs space-y-5">
                <h3 class="text-xl font-bold font-serif text-gray-900">Ringkasan Pesanan</h3>

                <!-- Selected Package Card -->
                <div class="flex items-center gap-3.5 pb-2">
                    <img src="{{ $heroImage }}" alt="{{ $paket->nm_paket }}" class="w-16 h-16 rounded-2xl object-cover shrink-0 shadow-xs border border-gray-100">
                    <div class="space-y-0.5">
                        <h4 class="font-bold text-sm text-[#2D5A27] leading-tight">Paket {{ $paket->nm_paket }}</h4>
                        <p class="text-[11px] text-gray-500 font-light">
                            Min. {{ $paket->nm_paket == 'Tumpeng' ? 1 : 20 }} Pax • Best Seller
                        </p>
                    </div>
                </div>

                <hr class="border-gray-100">

                <!-- Dates & Quantity Details -->
                <div class="space-y-2.5 text-xs text-gray-700">
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5 text-gray-600 font-light">
                            <span>📅</span> Tanggal
                        </span>
                        <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($tglAcara)->translatedFormat('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-1.5 text-gray-600 font-light">
                            <span>👥</span> Jumlah Pax
                        </span>
                        <span class="font-bold text-gray-900">{{ $jumlahPax }} Pax</span>
                    </div>
                    @if($selectedGubukan)
                        <div class="flex justify-between items-start gap-2">
                            <span class="flex items-center gap-1.5 text-gray-600 font-light shrink-0">
                                <span>🍲</span> Gubukan
                            </span>
                            <span class="font-bold text-gray-900 text-right">{{ $selectedGubukan->nama_gubukan }}</span>
                        </div>
                    @endif
                </div>

                <hr class="border-gray-100">

                <!-- Price Breakdown -->
                <div class="space-y-2 text-xs">
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Subtotal Paket</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($paketSubtotal, 0, ',', '.') }}</span>
                    </div>
                    @if($selectedGubukan)
                        <div class="flex justify-between text-gray-600 font-light">
                            <span>Gubukan ({{ $selectedGubukan->nama_gubukan }})</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($gubukanSubtotal, 0, ',', '.') }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Biaya Pengiriman</span>
                        <span class="text-green-700 font-medium">Gratis</span>
                    </div>
                </div>

                <!-- Total Box -->
                <div class="bg-[#F4F7EE] border border-[#E0EBD8] rounded-2xl p-4 flex justify-between items-center">
                    <span class="text-sm font-bold text-gray-800 font-serif">Total</span>
                    <span class="text-lg font-extrabold text-[#2D5A27] font-serif">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                </div>

                <!-- Error Alert -->
                <div id="checkoutErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3 rounded-lg">
                    <p id="checkoutErrorText" class="text-[11px] text-red-700 font-medium"></p>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="checkoutSubmitBtn" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-2xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs">
                    <span>Lanjutkan ke Ringkasan Pesanan</span>
                    <span class="text-sm">→</span>
                    <div id="checkoutSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                </button>

                <p class="text-[10.5px] text-gray-400 text-center font-light">
                    Tersedia pembayaran via Bank Transfer & E-Wallet
                </p>
            </div>

            <!-- Bottom Security Note -->
            <div class="flex items-center justify-center gap-1.5 text-[11px] text-gray-500 font-light py-1">
                <span>🛡️</span>
                <span>Secure Payment & Quality Guaranteed</span>
            </div>

        </div>

    </form>

</main>
@endsection

@section('modals')
<!-- SUCCESS CONFIRMATION MODAL -->
<div id="checkoutSuccessModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full text-center space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="w-16 h-16 bg-[#EBF5E8] text-[#2D5A27] rounded-full flex items-center justify-center mx-auto text-3xl font-bold shadow-xs">
            ✓
        </div>
        <div class="space-y-2">
            <h3 class="text-2xl font-bold font-serif text-gray-900">Pesanan Berhasil Dibuat!</h3>
            <p class="text-xs text-gray-600 font-light leading-relaxed">
                Terima kasih telah memesan di RASACI Catering. Tim kami akan segera memverifikasi pesanan Anda.
            </p>
        </div>
        <div class="pt-2 flex flex-col gap-2.5">
            <button type="button" onclick="openMyOrdersDrawer()" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3 rounded-xl transition-all text-xs cursor-pointer shadow-sm">
                Lihat Pesanan Saya
            </button>
            <a href="/" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-3 rounded-xl transition-all text-xs">
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    let map, marker;
    const defaultLat = -6.2088;
    const defaultLng = 106.8456;

    document.addEventListener("DOMContentLoaded", function () {
        initCheckoutMap();
    });

    function initCheckoutMap() {
        const mapContainer = document.getElementById('checkoutMap');
        if (!mapContainer) return;

        map = L.map('checkoutMap', {
            zoomControl: true,
        }).setView([defaultLat, defaultLng], 14);

        // Google Maps Interactive Vector Style Tiles
        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        }).addTo(map);

        const customPinIcon = L.divIcon({
            className: 'custom-pin-container',
            html: `
                <div class="custom-pin-marker">
                    <div class="pin-pulse"></div>
                    <svg viewBox="0 0 384 512" fill="#2D5A27" width="32" height="42">
                        <path d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"/>
                    </svg>
                </div>
            `,
            iconSize: [32, 42],
            iconAnchor: [16, 42],
            popupAnchor: [0, -40]
        });

        marker = L.marker([defaultLat, defaultLng], {
            draggable: true,
            icon: customPinIcon
        }).addTo(map);

        marker.bindPopup("<b>Titik Lokasi Pengiriman</b><br>Geser pin ini untuk titik presisi.").openPopup();

        marker.on('dragend', function (e) {
            const coord = marker.getLatLng();
            reverseGeocode(coord.lat, coord.lng);
        });

        map.on('click', function(e) {
            marker.setLatLng(e.latlng);
            reverseGeocode(e.latlng.lat, e.latlng.lng);
        });

        if (navigator.geolocation && !document.getElementById('alamat_pengiriman').value.trim()) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                reverseGeocode(lat, lng);
            }, function () {});
        }
    }

    let searchTimeout = null;

    function handleSearchInputKey(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            searchLocationOnMap();
            return;
        }

        const query = event.target.value.trim();
        if (query.length < 3) {
            hideSuggestions();
            return;
        }

        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            fetchSuggestions(query);
        }, 350);
    }

    function fetchSuggestions(query) {
        updateMapStatus("Mencari rekomendasi lokasi di Indonesia...", true);

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&viewbox=106.3,-6.7,107.2,-5.9&bounded=0&limit=6&addressdetails=1`)
            .then(res => res.json())
            .then(results => {
                const container = document.getElementById('searchSuggestions');
                if (!container) return;

                if (!results || results.length === 0) {
                    container.innerHTML = `
                        <div class="px-4 py-3 text-xs text-gray-500 text-center">
                            Tidak ada rekomendasi lokasi ditemukan di Indonesia
                        </div>
                    `;
                    container.classList.remove('hidden');
                    updateMapStatus("💡 Tekan Enter atau klik Cari untuk mencari ulang.", false);
                    return;
                }

                let html = '';
                results.forEach((item) => {
                    const title = item.name || (item.address && (item.address.road || item.address.suburb || item.address.village || item.address.city_district)) || item.display_name.split(',')[0];
                    const subtitle = item.display_name;
                    const lat = parseFloat(item.lat);
                    const lon = parseFloat(item.lon);
                    const safeDisplayName = item.display_name.replace(/'/g, "\\'");

                    html += `
                        <div onclick="selectLocationSuggestion(${lat}, ${lon}, '${safeDisplayName}')" 
                             class="px-4 py-3 hover:bg-[#F4F7EE] cursor-pointer transition-colors flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#2D5A27] shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 384 512">
                                <path d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0zM192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80-80 35.817-80 80 35.817 80 80 80z"/>
                            </svg>
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-gray-900 truncate">${title}</p>
                                <p class="text-[11px] text-gray-500 truncate leading-tight">${subtitle}</p>
                            </div>
                        </div>
                    `;
                });

                container.innerHTML = html;
                container.classList.remove('hidden');
                updateMapStatus("📍 Pilih lokasi dari daftar rekomendasi.", false);
            })
            .catch(() => {
                hideSuggestions();
            });
    }

    function selectLocationSuggestion(lat, lon, displayName) {
        document.getElementById('mapSearchInput').value = displayName;
        hideSuggestions();

        map.setView([lat, lon], 16);
        marker.setLatLng([lat, lon]);

        const textarea = document.getElementById('alamat_pengiriman');
        if (textarea) textarea.value = displayName;

        updateMapStatus("📍 Lokasi dipilih: " + displayName.split(',')[0], false);
    }

    function hideSuggestions() {
        const container = document.getElementById('searchSuggestions');
        if (container) container.classList.add('hidden');
    }

    document.addEventListener('click', function (e) {
        const searchInput = document.getElementById('mapSearchInput');
        const suggestions = document.getElementById('searchSuggestions');
        if (searchInput && suggestions && !searchInput.contains(e.target) && !suggestions.contains(e.target)) {
            hideSuggestions();
        }
    });

    function searchLocationOnMap() {
        const query = document.getElementById('mapSearchInput').value.trim();
        if (!query) return;

        hideSuggestions();
        updateMapStatus("Mencari lokasi '" + query + "'...", true);

        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&countrycodes=id&viewbox=106.3,-6.7,107.2,-5.9&bounded=0&limit=1&addressdetails=1`)
            .then(res => res.json())
            .then(results => {
                if (results && results.length > 0) {
                    const lat = parseFloat(results[0].lat);
                    const lon = parseFloat(results[0].lon);
                    const displayName = results[0].display_name;

                    map.setView([lat, lon], 16);
                    marker.setLatLng([lat, lon]);

                    const textarea = document.getElementById('alamat_pengiriman');
                    if (textarea) textarea.value = displayName;

                    updateMapStatus("📍 Lokasi ditemukan: " + displayName.split(',')[0], false);
                } else {
                    updateMapStatus("❌ Lokasi tidak ditemukan. Coba kata kunci lain.", false);
                }
            })
            .catch(() => {
                updateMapStatus("❌ Gagal mencari lokasi.", false);
            });
    }

    function getCurrentLocation() {
        if (!navigator.geolocation) {
            alert('Geofencing tidak didukung oleh browser Anda.');
            return;
        }

        updateMapStatus("Mendeteksi GPS Anda...", true);

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                map.setView([lat, lng], 16);
                marker.setLatLng([lat, lng]);
                reverseGeocode(lat, lng);
                updateMapStatus("🎯 Berhasil mendapatkan lokasi GPS Anda!", false);
            },
            function (error) {
                updateMapStatus("⚠️ Gagal mengambil GPS. Pastikan izin lokasi diaktifkan.", false);
            }
        );
    }

    function reverseGeocode(lat, lng) {
        updateMapStatus("Mengambil nama alamat...", true);

        fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
            .then(res => res.json())
            .then(data => {
                if (data && data.display_name) {
                    const textarea = document.getElementById('alamat_pengiriman');
                    if (textarea) textarea.value = data.display_name;
                    updateMapStatus("📍 Alamat diperbarui: " + (data.address.road || data.address.suburb || data.display_name.split(',')[0]), false);
                } else {
                    updateMapStatus("💡 Klik pada peta atau geser pin 📍 untuk menyesuaikan titik lokasi.", false);
                }
            })
            .catch(() => {
                updateMapStatus("💡 Klik pada peta atau geser pin 📍 untuk menyesuaikan titik lokasi.", false);
            });
    }

    function updateMapStatus(text, isLoading) {
        const statusText = document.getElementById('mapStatusText');
        const loader = document.getElementById('mapLoader');
        if (statusText) statusText.innerText = text;
        if (loader) {
            if (isLoading) loader.classList.remove('hidden');
            else loader.classList.add('hidden');
        }
    }

    function openMyOrdersDrawer() {
        const modal = document.getElementById('checkoutSuccessModal');
        if (modal) modal.classList.add('hidden');
        if (typeof toggleMyOrders === 'function') {
            toggleMyOrders();
        } else {
            window.location.href = '/';
        }
    }

    function submitCheckoutOrder(event) {
        event.preventDefault();

        const alamat = document.getElementById('alamat_pengiriman').value.trim();
        const catatan = document.getElementById('catatan').value.trim();
        const errBanner = document.getElementById('checkoutErrorBanner');
        const errText = document.getElementById('checkoutErrorText');

        if (!alamat) {
            if (errBanner && errText) {
                errText.innerText = 'Silakan isi alamat pengiriman lengkap Anda terlebih dahulu.';
                errBanner.classList.remove('hidden');
            }
            return;
        }

        let url = '{{ route("pembayaran") }}?paket_id={{ $paket->id }}'
            + '&jumlah_pax={{ $jumlahPax }}'
            + '&tgl_acara=' + encodeURIComponent('{{ $tglAcara }}')
            + '&lauk_ids=' + encodeURIComponent('{{ implode(",", $laukIds) }}')
            + '&alamat_pengiriman=' + encodeURIComponent(alamat)
            + '&catatan=' + encodeURIComponent(catatan);

        @if($selectedGubukan)
            url += '&gubukan_id={{ $selectedGubukan->id }}';
        @endif

        window.location.href = url;
    }
</script>
@endsection
