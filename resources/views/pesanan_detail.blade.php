@extends('layouts.app')

@section('title', 'Order #ORD-' . str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) . ' - RASACI Catering')

@section('styles')
<!-- Leaflet.js CSS for Map -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
    #orderDetailMap {
        z-index: 1;
    }
</style>
@endsection

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- BREADCRUMBS -->
    <nav class="flex text-xs text-gray-500 font-medium space-x-2">
        <a href="/" class="hover:text-gray-900 transition-colors">Beranda</a>
        <span>›</span>
        <a href="{{ route('pesanan.index') }}" class="hover:text-gray-900 transition-colors">Pesanan Saya</a>
        <span>›</span>
        <span class="text-gray-900 font-bold">ORD-{{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('Y') }}-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}</span>
    </nav>

    @php
        $statusRaw = strtolower($pesanan->status_pesanan);
        $prodStatus = strtolower($pesanan->status_produksi);
        $shipStatus = $pesanan->pengiriman ? strtolower($pesanan->pengiriman->status_pengiriman) : 'belum_dikirim';
        $hasDpPaid = $pesanan->pembayarans && $pesanan->pembayarans->count() > 0;

        // Map status to progress step (1 to 5)
        $step = 1; // Default: Menunggu DP
        $statusText = 'Menunggu DP';
        $statusBg = 'bg-[#FDF0ED] text-[#8A3017]';
        $timelineMessage = $hasDpPaid
            ? 'Pembayaran DP (50%) telah tercatat/diunggah. Menunggu konfirmasi pesanan dari penjual.'
            : 'Silakan lakukan pembayaran DP (50%) agar pesanan Anda dapat dikonfirmasi oleh penjual.';

        if (in_array($statusRaw, ['batal', 'dibatalkan', 'ditolak'])) {
            $step = 1;
            $statusText = 'Dibatalkan';
            $statusBg = 'bg-red-100 text-red-800';
            $timelineMessage = 'Pesanan ini telah dibatalkan.';
        } elseif ($statusRaw === 'selesai' || $shipStatus === 'sampai') {
            $step = 5;
            $statusText = 'Selesai';
            $statusBg = 'bg-[#EAEFE2] text-[#3B420C]';
            $timelineMessage = 'Pesanan Anda telah selesai disajikan dan tiba di lokasi. Terima kasih telah memercayakan momen Anda kepada RASACI Catering!';
        } elseif ($shipStatus === 'dikirim') {
            $step = 4;
            $statusText = 'Dikirim';
            $statusBg = 'bg-green-600 text-white';
            $timelineMessage = 'Kurir kami sedang dalam perjalanan menuju lokasi Anda. Estimasi tiba dalam 15-20 menit.';
        } elseif ($prodStatus === 'diproses') {
            $step = 3;
            $statusText = 'Diproses';
            $statusBg = 'bg-[#EBF5E8] text-[#2D5A27]';
            $timelineMessage = 'Dapur RASACI Catering sedang memasak dan menyiapkan hidangan untuk acara Anda.';
        } elseif (in_array($statusRaw, ['disetujui', 'dikonfirmasi'])) {
            $step = 2;
            $statusText = 'Dikonfirmasi';
            $statusBg = 'bg-[#EBF5E8] text-[#2D5A27]';
            $timelineMessage = 'Pesanan Anda telah dikonfirmasi oleh tim RASACI Catering dan siap diproses.';
        }

        // Calculations
        $paketSubtotal = 0;
        foreach ($pesanan->pesananPaket as $item) {
            $paketSubtotal += ($item->paket->harga_paket ?? 0) * ($item->jml_paket ?? $pesanan->jumlah_pax);
        }
        $gubukanSubtotal = $pesanan->gubukan ? ($pesanan->gubukan->harga_gubukan * $pesanan->jumlah_pax) : 0;
        $deliveryFee = $pesanan->biaya_pengiriman ?? 150000;
        $grandTotal = $pesanan->total_harga > 0 ? $pesanan->total_harga : ($paketSubtotal + $gubukanSubtotal + $deliveryFee);
        $dpPaid = $grandTotal * 0.5;
        $remainingBalance = $grandTotal * 0.5;
    @endphp

    <!-- HEADER TITLE & PRINT ACTION -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="space-y-1">
            <div class="flex items-center gap-3">
                <h1 class="text-3xl sm:text-4xl font-extrabold font-serif text-gray-900 tracking-tight">
                    Order #ORD-{{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('Y') }}-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}
                </h1>
                <span class="px-3 py-1 rounded-full text-xs font-bold shadow-2xs {{ $statusBg }}">
                    ● {{ $statusText }}
                </span>
            </div>
            <p class="text-xs text-gray-500 font-light">
                Placed on {{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->translatedFormat('F d, Y • h:i A') }}
            </p>
        </div>

        <button type="button" onclick="window.print()" class="px-4 py-2.5 bg-[#EAEFE2] hover:bg-[#DCECD8] text-gray-800 font-bold text-xs rounded-xl shadow-xs border border-[#D2E6CE] inline-flex items-center gap-2 transition-all cursor-pointer self-start sm:self-center">
            <span>🖨️</span>
            <span>Cetak Invoice</span>
        </button>
    </div>

    <!-- SHIPPING / ORDER TIMELINE BANNER -->
    <div class="bg-[#F8F9F3] rounded-3xl p-6 sm:p-8 border border-[#E5E8DD] shadow-xs space-y-6">
        <!-- Progress Line & Steps -->
        <div class="relative max-w-3xl mx-auto py-3 px-2">
            <!-- Background Line -->
            <div class="absolute top-1/2 left-6 right-6 h-1 bg-gray-200 -translate-y-1/2 z-0"></div>
            <!-- Active Line -->
            @php
                $linePct = 0;
                if ($step === 2) $linePct = 25;
                elseif ($step === 3) $linePct = 50;
                elseif ($step === 4) $linePct = 75;
                elseif ($step === 5) $linePct = 100;
            @endphp
            <div class="absolute top-1/2 left-6 h-1 bg-[#2D5A27] -translate-y-1/2 z-0 transition-all duration-500" style="width: calc({{ $linePct }}% - 24px);"></div>

            <!-- Steps Grid -->
            <div class="relative z-10 flex justify-between items-center text-center">
                <!-- Step 1: Menunggu DP -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-xs {{ $step >= 1 ? 'bg-[#2D5A27] text-white ring-4 ring-[#EBF5E8]' : 'bg-gray-200 text-gray-500' }}">
                        ✓
                    </div>
                    <span class="text-[11px] font-bold text-gray-700">Menunggu DP</span>
                </div>

                <!-- Step 2: Dikonfirmasi -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-xs {{ $step >= 2 ? 'bg-[#2D5A27] text-white ring-4 ring-[#EBF5E8]' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                        ✓
                    </div>
                    <span class="text-[11px] font-bold text-gray-700">Dikonfirmasi</span>
                </div>

                <!-- Step 3: Diproses -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-xs {{ $step >= 3 ? 'bg-[#2D5A27] text-white ring-4 ring-[#EBF5E8]' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                        ✓
                    </div>
                    <span class="text-[11px] font-bold text-gray-700">Diproses</span>
                </div>

                <!-- Step 4: Dikirim -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-xs {{ $step >= 4 ? 'bg-[#2D5A27] text-white ring-4 ring-[#EBF5E8]' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                        🚚
                    </div>
                    <span class="text-[11px] font-bold text-gray-700">Dikirim</span>
                </div>

                <!-- Step 5: Selesai -->
                <div class="flex flex-col items-center gap-2">
                    <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all shadow-xs {{ $step >= 5 ? 'bg-[#2D5A27] text-white ring-4 ring-[#EBF5E8]' : 'bg-white border-2 border-gray-300 text-gray-400' }}">
                        ✓
                    </div>
                    <span class="text-[11px] font-bold text-gray-700">Selesai</span>
                </div>
            </div>
        </div>

        <!-- Active Status Description Banner -->
        <div class="bg-white rounded-2xl p-4 border border-[#E5E8DD] text-center shadow-2xs">
            <p class="text-xs font-medium text-gray-800 leading-relaxed">
                {{ $timelineMessage }}
            </p>
        </div>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- LEFT COLUMN: ORDER ITEMS & DELIVERY INFO (Span 7) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 1: Order Items -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-5">
                <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">🍴</span>
                        <h2 class="text-xl font-bold font-serif text-gray-900">Order Items</h2>
                    </div>
                    <span class="text-xs font-bold text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                        {{ $pesanan->pesananPaket->count() + ($pesanan->gubukan ? 1 : 0) }} Items
                    </span>
                </div>

                <!-- Items List -->
                <div class="space-y-4 divide-y divide-gray-100">
                    <!-- Main Package Items -->
                    @foreach($pesanan->pesananPaket as $item)
                        @php
                            $paketObj = $item->paket;
                            $itemHeroImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300';
                            if ($paketObj && str_contains(strtolower($paketObj->nm_paket), 'prasmanan')) {
                                $itemHeroImage = 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=300';
                            } elseif ($paketObj && str_contains(strtolower($paketObj->nm_paket), 'tumpeng')) {
                                $itemHeroImage = 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?auto=format&fit=crop&q=80&w=300';
                            }
                        @endphp
                        <div class="pt-4 first:pt-0 flex gap-4 items-start justify-between">
                            <div class="flex gap-4 items-start min-w-0">
                                <img src="{{ $itemHeroImage }}" alt="{{ $paketObj->nm_paket ?? 'Paket' }}" class="w-16 h-16 rounded-2xl object-cover border border-gray-100 shrink-0">
                                <div class="space-y-1 min-w-0">
                                    <h4 class="text-base font-bold font-serif text-gray-900 truncate">
                                        {{ $paketObj->nm_paket ?? 'Paket Catering' }}
                                    </h4>
                                    <p class="text-xs text-gray-500 font-light">
                                        {{ $item->jml_paket ?? $pesanan->jumlah_pax }} Pax • Buffet Service • Traditional Theme
                                    </p>
                                    <div class="flex gap-1.5 pt-0.5">
                                        <span class="px-2 py-0.5 rounded bg-[#EBF5E8] text-[#2D5A27] text-[9px] font-bold uppercase">HALAL</span>
                                        <span class="px-2 py-0.5 rounded bg-[#EBF5E8] text-[#2D5A27] text-[9px] font-bold uppercase">AUTENTIK</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right whitespace-nowrap">
                                <span class="text-sm font-bold text-gray-900 font-serif">
                                    Rp {{ number_format(($paketObj->harga_paket ?? 0) * ($item->jml_paket ?? $pesanan->jumlah_pax), 0, ',', '.') }}
                                </span>
                            </div>
                        </div>

                        <!-- Lauk choices list if any -->
                        @if($item->lauks && $item->lauks->count() > 0)
                        <div class="pl-20 text-xs text-gray-500 space-y-1">
                            <span class="font-bold text-gray-700 text-[11px]">Pilihan Lauk:</span>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($item->lauks as $pLauk)
                                    @if($pLauk->lauk)
                                    <span class="bg-gray-100 border border-gray-200 px-2 py-0.5 rounded-md text-[10.5px]">
                                        {{ $pLauk->lauk->nama_lauk }}
                                    </span>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    @endforeach

                    <!-- Gubukan Item if selected -->
                    @if($pesanan->gubukan)
                    <div class="pt-4 flex gap-4 items-start justify-between">
                        <div class="flex gap-4 items-start min-w-0">
                            <img src="https://images.unsplash.com/photo-1569718212165-3a8278d5f624?auto=format&fit=crop&q=80&w=300" alt="{{ $pesanan->gubukan->nama_gubukan }}" class="w-16 h-16 rounded-2xl object-cover border border-gray-100 shrink-0">
                            <div class="space-y-1 min-w-0">
                                <h4 class="text-base font-bold font-serif text-gray-900 truncate">
                                    Gubukan - {{ $pesanan->gubukan->nama_gubukan }}
                                </h4>
                                <p class="text-xs text-gray-500 font-light">
                                    {{ $pesanan->jumlah_pax }} Pax • Special Gubukan Stall
                                </p>
                            </div>
                        </div>
                        <div class="text-right whitespace-nowrap">
                            <span class="text-sm font-bold text-gray-900 font-serif">
                                Rp {{ number_format($pesanan->gubukan->harga_gubukan * $pesanan->jumlah_pax, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Card 2: Delivery Information -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-5">
                <div class="flex items-center gap-2.5 pb-2 border-b border-gray-100">
                    <span class="text-xl">📍</span>
                    <h2 class="text-xl font-bold font-serif text-gray-900">Delivery Information</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 text-xs">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">RECIPIENT</span>
                        <p class="font-bold text-gray-900 text-sm">{{ $pesanan->user->name ?? 'Pelanggan RASACI' }}</p>
                        <p class="text-gray-500">{{ $pesanan->user->no_hp ?? '+62 812 3456 7890' }}</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">DELIVERY ADDRESS</span>
                        <p class="font-medium text-gray-800 leading-relaxed">{{ $pesanan->alamat_pengiriman }}</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">DELIVERY TIME</span>
                        <p class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($pesanan->tgl_acara)->translatedFormat('F d, Y') }}</p>
                        <p class="text-gray-500">Arriving by 10:00 AM</p>
                    </div>

                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">INSTRUCTIONS</span>
                        <p class="text-gray-600 italic leading-relaxed">"{{ $pesanan->catatan ?? 'Tidak ada instruksi khusus.' }}"</p>
                    </div>
                </div>

                <!-- Leaflet Interactive Map Container -->
                <div id="orderDetailMap" class="w-full h-56 rounded-2xl border border-gray-200 overflow-hidden relative mt-2"></div>
            </div>

        </div>

        <!-- RIGHT COLUMN: STICKY PAYMENT SUMMARY (Span 5) -->
        <div class="lg:col-span-5 sticky top-24 space-y-5">

            <!-- Card 1: Payment Summary -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-sm space-y-5">
                <div class="flex items-center gap-2 pb-2 border-b border-gray-100">
                    <span class="text-xl">💳</span>
                    <h3 class="text-xl font-bold font-serif text-gray-900">Payment</h3>
                </div>

                <!-- Price Breakdown -->
                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Subtotal</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($paketSubtotal + $gubukanSubtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Tax (0%)</span>
                        <span class="text-[#2D5A27] font-medium">Free</span>
                    </div>

                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Delivery Fee</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>

                    <div class="pt-2 border-t border-gray-100 flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-900 font-serif">Total</span>
                        <span class="text-lg font-extrabold text-gray-900 font-serif">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- DP Paid Box -->
                <div class="bg-[#F8F9F3] border border-[#E5E8DD] rounded-2xl p-3.5 flex justify-between items-center text-xs">
                    <div>
                        <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider block">DP PAID (50%)</span>
                        <span class="text-sm font-bold text-gray-900 font-serif">Rp {{ number_format($dpPaid, 0, ',', '.') }}</span>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold">Verified</span>
                </div>

                <!-- Remaining Balance Box -->
                <div class="pt-2 border-t border-gray-100 space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">REMAINING BALANCE</span>
                        <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 text-[10px] font-bold">Pending</span>
                    </div>

                    <div class="flex justify-between items-baseline">
                        <span class="text-2xl font-extrabold text-gray-900 font-serif">Unpaid</span>
                        <span class="text-2xl font-black text-gray-900 font-serif">Rp {{ number_format($remainingBalance, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Notice -->
                <div class="p-3 bg-gray-50 rounded-xl border border-gray-200 text-[11px] text-gray-600 flex items-start gap-2">
                    <span class="text-sm">ℹ️</span>
                    <p class="leading-relaxed">
                        Please settle the remaining balance to complete your order process.
                    </p>
                </div>

                <!-- Pelunasan Action Button -->
                <a href="https://wa.me/6281234567890?text=Halo%20RASACI%20Kitchen,%20saya%20ingin%20melakukan%20pelunasan%20sisa%20pembayaran%20untuk%20Order%20%23ORD-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}" target="_blank" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-2xl transition-all shadow-md flex items-center justify-center gap-2 text-xs cursor-pointer">
                    <span>Selesaikan Pelunasan</span>
                </a>

                <p class="text-[10px] text-gray-400 text-center font-light">
                    Secure payment powered by Midtrans / Bank Transfer
                </p>
            </div>

            <!-- Card 2: Need Help Card -->
            <div class="bg-[#F8F9F3] border border-[#E5E8DD] rounded-3xl p-5 space-y-3 text-xs">
                <h4 class="font-bold text-gray-900">Need help with this order?</h4>
                <div class="space-y-2">
                    <a href="https://wa.me/6281234567890?text=Halo%20RASACI%20Kitchen,%20saya%20butuh%20bantuan%20mengenai%20Order%20%23ORD-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}" target="_blank" class="flex items-center gap-2 text-gray-700 hover:text-brand-green font-medium transition-colors">
                        <span>💬</span>
                        <span>Chat with Support</span>
                    </a>
                    <a href="#" class="flex items-center gap-2 text-gray-700 hover:text-brand-green font-medium transition-colors">
                        <span>📄</span>
                        <span>View Terms & Conditions</span>
                    </a>
                </div>
            </div>

        </div>

    </div>

</main>
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Map Initialization
        const defaultLat = -6.2088;
        const defaultLng = 106.8456;

        const map = L.map('orderDetailMap').setView([defaultLat, defaultLng], 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        const customIcon = L.divIcon({
            className: 'custom-div-icon',
            html: "<div style='background-color:#2D5A27; color:white; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-center; border:2px solid white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); font-size:18px;'>📍</div>",
            iconSize: [36, 36],
            iconAnchor: [18, 36]
        });

        L.marker([defaultLat, defaultLng], { icon: customIcon }).addTo(map)
            .bindPopup("<b>Alamat Pengiriman</b><br>{{ Str::limit($pesanan->alamat_pengiriman, 50) }}")
            .openPopup();
    });
</script>
@endsection
