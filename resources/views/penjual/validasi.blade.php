@extends('layouts.admin')

@section('title', 'Payment Validation - Order #RS-' . str_pad($pesanan->id, 4, '0', STR_PAD_LEFT))

@section('content')
<!-- TOP NAVIGATION & ACTION HEADER -->
<div class="space-y-4">
    <!-- Back to Orders Link -->
    <a href="{{ route('penjual.orders') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-gray-600 hover:text-[#2D5A27] transition-colors">
        <span>←</span>
        <span>Back to Orders</span>
    </a>

    <!-- Alerts Notification -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-green-100 border border-green-200 text-green-800 text-xs font-bold flex items-center gap-2">
            <span>✅</span>
            <span>{{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-100 border border-red-200 text-red-800 text-xs font-bold flex items-center gap-2">
            <span>⚠️</span>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <h1 class="text-3xl sm:text-4xl font-black font-serif text-gray-900 tracking-tight">
                    Order #RS-{{ str_pad($pesanan->id, 4, '0', STR_PAD_LEFT) }}
                </h1>
                <!-- Status Pill -->
                @php
                    $statusRaw = strtolower($pesanan->status_pesanan);
                    $prodStatus = strtolower($pesanan->status_produksi);
                    $shipStatus = $pesanan->pengiriman ? strtolower($pesanan->pengiriman->status_pengiriman) : 'belum_dikirim';
                @endphp
                @if($statusRaw === 'disetujui' || $statusRaw === 'dikonfirmasi')
                    <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-xs font-bold">Dikonfirmasi</span>
                @elseif($statusRaw === 'selesai')
                    <span class="px-3 py-1 rounded-full bg-[#EAEFE2] text-[#3B420C] text-xs font-bold">Selesai</span>
                @elseif($statusRaw === 'batal' || $statusRaw === 'ditolak')
                    <span class="px-3 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold">Ditolak</span>
                @else
                    <span class="px-3 py-1 rounded-full bg-[#FDF0ED] text-[#8A3017] text-xs font-bold">Waiting Validation</span>
                @endif
            </div>
            <p class="text-xs text-gray-500 font-light mt-1">
                Placed on {{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->format('M d, Y • H:i A') }}
            </p>
        </div>

        <!-- Top Right Action Buttons -->
        <div class="flex items-center gap-3">
            <button type="button" onclick="window.print()" class="px-4 py-2.5 bg-white border border-gray-300 rounded-xl font-bold text-xs text-gray-700 hover:bg-gray-50 shadow-2xs transition-all cursor-pointer">
                Print Invoice
            </button>
            <button type="button" onclick="window.print()" class="px-4 py-2.5 bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold rounded-xl text-xs shadow-md transition-all cursor-pointer">
                Download PDF
            </button>
        </div>
    </div>
</div>

<!-- MAIN 2-COLUMN GRID -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- LEFT COLUMN (SPAN 8) -->
    <div class="lg:col-span-8 space-y-8">
        
        <!-- CARD 1: DETAIL PEMBAYARAN -->
        @php
            $pembayaran = $pesanan->pembayarans()->latest()->first();
            $hasPaidDp = $pesanan->pembayarans()
                ->whereIn('status_bayar', ['diverifikasi', 'lunas'])
                ->exists();
        @endphp
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <span class="text-xl">🛡️</span>
                    <h2 class="text-xl font-bold font-serif text-gray-900">Detail Pembayaran DP</h2>
                </div>
                <span class="text-xs font-bold text-[#8A3017] uppercase tracking-wider font-mono">
                    IDR {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }} (50% DP)
                </span>
            </div>

            <div class="space-y-4 text-xs">
                <!-- Status Banner -->
                @if($hasPaidDp)
                    <div class="p-4 bg-green-50 text-green-850 rounded-2xl border border-green-200 flex items-center gap-3">
                        <span class="text-2xl">✅</span>
                        <div>
                            <span class="font-bold text-xs block text-green-900">Uang Muka (DP) Terbayar</span>
                            <span class="text-[10px] text-green-600 font-light block">Pembayaran DP 50% berhasil diverifikasi otomatis oleh sistem.</span>
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-red-50 text-red-850 rounded-2xl border border-red-200 flex items-center gap-3">
                        <span class="text-2xl">⚠️</span>
                        <div>
                            <span class="font-bold text-xs block text-red-900">Uang Muka (DP) Belum Dibayar</span>
                            <span class="text-[10px] text-red-600 font-light block">Pelanggan belum melakukan transaksi pembayaran DP.</span>
                        </div>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Bank Name -->
                    <div class="p-3.5 bg-[#F8F9F3] rounded-2xl border border-gray-100 space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase block">Metode Pembayaran</span>
                        <span class="font-bold text-gray-900 text-xs block">
                            {{ $pembayaran ? ($pembayaran->metode_bayar === 'bank_transfer' ? 'Transfer Bank (Manual)' : 'Midtrans Snap Gateway') : 'Belum Ditentukan' }}
                        </span>
                    </div>

                    <!-- Sender Name -->
                    <div class="p-3.5 bg-[#F8F9F3] rounded-2xl border border-gray-100 space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase block">Nama Pelanggan</span>
                        <span class="font-bold text-gray-900 text-xs block">{{ $pesanan->user->name ?? '-' }}</span>
                    </div>

                    <!-- Transaction Date -->
                    <div class="p-3.5 bg-[#F8F9F3] rounded-2xl border border-gray-100 space-y-1">
                        <span class="text-[10px] font-bold text-gray-400 uppercase block">Tanggal Acara</span>
                        <span class="font-bold text-gray-900 text-xs block">{{ \Carbon\Carbon::parse($pesanan->tgl_acara)->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2: ORDER SUMMARY -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
            <div class="flex items-center gap-2 pb-4 border-b border-gray-100">
                <span class="text-xl">🛍️</span>
                <h2 class="text-xl font-bold font-serif text-gray-900">Order Summary</h2>
            </div>

            <!-- Items Breakdown List -->
            <div class="space-y-4">
                @php
                    $mainPaket = $pesanan->pesananPaket->first()?->paket;
                @endphp
                <!-- Main Package Card -->
                <div class="p-4 bg-[#F8F9F3] rounded-2xl border border-gray-100 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <img src="https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=200" alt="Package Photo" class="w-16 h-12 rounded-xl object-cover border border-gray-200">
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs sm:text-sm">{{ $mainPaket->nm_paket ?? 'Golden Nusantara Wedding Package' }}</h4>
                            <p class="text-[11px] text-gray-500 font-light mt-0.5">{{ $pesanan->jumlah_pax ?? 500 }} Pax • Premium Buffet Service</p>
                        </div>
                    </div>
                    <div class="text-right font-serif">
                        <span class="font-bold text-gray-900 text-sm block">IDR {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                        <span class="text-[10px] text-gray-400 font-sans">IDR 17,000/pax</span>
                    </div>
                </div>

                <!-- Gubukan Card if exists -->
                @if($pesanan->gubukan)
                <div class="p-4 bg-[#F8F9F3] rounded-2xl border border-gray-100 flex items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-12 rounded-xl bg-[#EAEFE2] text-[#2D5A27] font-bold flex items-center justify-center text-lg border border-gray-200">
                            🍲
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-xs sm:text-sm">{{ $pesanan->gubukan->nama_gubukan }}</h4>
                            <p class="text-[11px] text-gray-500 font-light mt-0.5">Assorted Stalls & Live Station</p>
                        </div>
                    </div>
                    <div class="text-right font-serif">
                        <span class="font-bold text-gray-900 text-sm block">IDR {{ number_format(($pesanan->gubukan->harga_gubukan ?? 0) * $pesanan->jumlah_pax, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
            </div>

            <!-- Price Breakdown Calculation -->
            <div class="pt-4 border-t border-gray-100 space-y-2 text-xs text-gray-600">
                <div class="flex justify-between font-medium">
                    <span>Subtotal</span>
                    <span class="font-mono text-gray-900">IDR {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Service Charge (0%)</span>
                    <span class="font-mono text-gray-900">IDR 0</span>
                </div>
                <div class="flex justify-between font-medium">
                    <span>Tax (0% Free)</span>
                    <span class="font-mono text-gray-900">IDR 0</span>
                </div>
                <div class="pt-3 border-t border-gray-200 flex justify-between items-center text-gray-900">
                    <span class="text-sm font-bold font-serif">Total Amount</span>
                    <span class="text-xl font-black font-serif text-[#2D5A27]">IDR {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT COLUMN (SPAN 4) -->
    <div class="lg:col-span-4 space-y-8">
        
        <!-- CARD 1: ORDER STATUS CONTROL -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-4">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block">ORDER STATUS CONTROL</span>
            
            <form action="{{ route('penjual.orders.validasi.action', $pesanan->id) }}" method="POST" class="space-y-3">
                @csrf
                <div class="space-y-1.5 text-xs">
                    <label class="font-medium text-gray-600 block">Change Status To:</label>
                    <select name="status_stage" class="w-full p-3 bg-[#F8F9F3] border border-gray-200 rounded-xl font-bold text-gray-900 focus:outline-none">
                        <option value="menunggu_validasi" {{ $statusRaw === 'menunggu_validasi' ? 'selected' : '' }}>Waiting Validation</option>
                        <option value="disetujui" {{ $statusRaw === 'disetujui' ? 'selected' : '' }}>Dikonfirmasi / Approved</option>
                        <option value="diproses" {{ $prodStatus === 'diproses' ? 'selected' : '' }}>In Kitchen (Diproses)</option>
                        <option value="dikirim" {{ $shipStatus === 'dikirim' ? 'selected' : '' }}>With Courier (Dikirim)</option>
                        <option value="selesai" {{ $statusRaw === 'selesai' ? 'selected' : '' }}>Delivered / Selesai</option>
                    </select>
                </div>

                <button type="submit" class="w-full bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3 rounded-xl text-xs shadow-md transition-all cursor-pointer">
                    Update Status
                </button>
            </form>
        </div>

        <!-- CARD 2: CUSTOMER CONTACT INFO -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-5 text-xs">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block">CUSTOMER CONTACT INFO</span>

            <div class="flex items-center gap-3">
                @php
                    $cName = $pesanan->user->name ?? 'Amanda Rizky';
                    $initials = strtoupper(substr($cName, 0, 2));
                @endphp
                <div class="w-12 h-12 rounded-full bg-[#EAEFE2] text-[#2D5A27] font-black text-sm flex items-center justify-center shrink-0 border border-gray-200">
                    {{ $initials }}
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm">{{ $cName }}</h4>
                    <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md inline-block mt-0.5">Membership: Gold</span>
                </div>
            </div>

            <div class="space-y-3 pt-2 text-gray-700 font-medium">
                <div class="flex items-start gap-2.5">
                    <span class="text-sm text-gray-400">✉️</span>
                    <span class="break-all">{{ $pesanan->user->email ?? 'amanda.rizky@email.com' }}</span>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="text-sm text-gray-400">📞</span>
                    <span>{{ $pesanan->user->no_telp ?? '+62 812-3456-7890' }}</span>
                </div>
                <div class="flex items-start gap-2.5">
                    <span class="text-sm text-gray-400">📍</span>
                    <span class="font-light leading-relaxed">{{ $pesanan->alamat_pengiriman ?? 'Griya Asri Residence Block C-14, BSD City, Tangerang Selatan' }}</span>
                </div>
            </div>

            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pesanan->user->no_telp ?? '081234567890') }}" target="_blank" class="w-full border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 rounded-xl flex items-center justify-center gap-2 text-xs transition-all shadow-2xs">
                <span>💬</span>
                <span>Contact WhatsApp</span>
            </a>
        </div>

        <!-- CARD 3: INTERNAL STAFF NOTES -->
        <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-4">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block">INTERNAL STAFF NOTES</span>
            
            <textarea rows="3" placeholder="Add private notes for the kitchen or delivery team..." class="w-full p-3 bg-[#F8F9F3] border border-gray-200 rounded-2xl text-xs font-medium focus:outline-none focus:bg-white"></textarea>

            <div class="flex items-center justify-between pt-1">
                <span class="text-[10px] text-gray-400 font-light">🔒 Only visible to staff</span>
                <button type="button" onclick="alert('Catatan staff tersimpan!')" class="bg-[#2D5A27] text-white font-bold px-4 py-2 rounded-xl text-xs shadow-xs cursor-pointer">
                    Save Notes
                </button>
            </div>
        </div>

        <!-- CARD 4: DELIVERY MAP PREVIEW -->
        <div class="bg-white rounded-3xl p-3 border border-[#E5E5DC] shadow-xs space-y-2">
            <div id="validasiDeliveryMap" class="w-full h-44 rounded-2xl border border-gray-200 z-10"></div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('scripts')
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Default coordinates for Jakarta / BSD City
        var lat = {{ $pesanan->latitude ?? -6.3016 }};
        var lng = {{ $pesanan->longitude ?? 106.6538 }};

        var map = L.map('validasiDeliveryMap').setView([lat, lng], 14);

        L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20,
            subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
            attribution: '&copy; Google Maps'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map)
            .bindPopup('<b>Lokasi Pengiriman</b><br>{{ addslashes($pesanan->alamat_pengiriman ?? "Griya Asri Residence") }}')
            .openPopup();
    });
</script>
@endsection
