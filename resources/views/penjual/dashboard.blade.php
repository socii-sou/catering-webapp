@extends('layouts.admin')

@section('title', 'Ringkasan Dashboard - Manajemen Dapur RASACI')

@section('content')
<!-- TOP ACTION BAR: CETAK PDF LAPORAN PENJUALAN -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white p-5 rounded-3xl border border-[#E5E5DC] shadow-xs">
    <div class="space-y-0.5">
        <h2 class="text-xl font-bold font-serif text-gray-900">Ringkasan Operational Dapur</h2>
        <p class="text-xs text-gray-500 font-light">Pantau performa penjualan, total pendapatan, dan cetak rekapitulasi laporan resmi.</p>
    </div>
    <a href="{{ route('penjual.laporan.cetak') }}" target="_blank" class="bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3 px-6 rounded-2xl shadow-md text-xs flex items-center justify-center gap-2.5 transition-all cursor-pointer hover:shadow-lg shrink-0">
        <span class="text-base">📄</span>
        <span>Cetak PDF Laporan Penjualan</span>
    </a>
</div>

<!-- 3 METRIC CARDS GRID -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <!-- Card 1: TOTAL PESANAN -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL PESANAN</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ number_format($totalOrdersCount, 0, ',', '.') }}
            </div>
            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                <span>Semua Pesanan Aktif</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-xl shrink-0">
            <svg class="w-6 h-6 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
        </div>
    </div>

    <!-- Card 2: TOTAL PENDAPATAN -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL PENDAPATAN</span>
            <div class="text-xl sm:text-2xl font-extrabold font-serif text-gray-900 truncate">
                Rp {{ number_format($totalRevenueSum, 0, ',', '.') }}
            </div>
            <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>Total Omzet Aktif</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-xl shrink-0">
            <svg class="w-6 h-6 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
        </div>
    </div>

    <!-- Card 3: MENUNGGU VALIDASI -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">MENUNGGU VALIDASI</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $pendingPaymentsCount }}
            </div>
            <div class="flex items-center gap-1.5 text-xs font-bold {{ $pendingPaymentsCount > 0 ? 'text-amber-600' : 'text-emerald-700' }}">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ $pendingPaymentsCount > 0 ? 'Perlu Tindakan Penjual' : 'Semua Tervalidasi' }}</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
            <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
            </svg>
        </div>
    </div>
</div>

<!-- BOTTOM SECTION: PESANAN TERBARU TABLE -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <h3 class="text-2xl font-bold font-serif text-gray-900">Pesanan Terbaru</h3>
        <a href="{{ route('penjual.orders') }}" class="text-xs font-bold text-gray-600 hover:text-[#2D5A27] transition-colors">
            Lihat Semua Pesanan &rarr;
        </a>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">ID PESANAN</th>
                    <th class="py-3 px-4">PELANGGAN</th>
                    <th class="py-3 px-4">PAKET</th>
                    <th class="py-3 px-4">STATUS</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">TOTAL</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 font-medium">
                @forelse($recentOrders as $order)
                    @php
                        $paketItem = $order->pesananPaket->first()?->paket;
                        $statusRaw = strtolower($order->status_pesanan);
                        $prodStatus = strtolower($order->status_produksi);
                        $shipStatus = $order->pengiriman ? strtolower($order->pengiriman->status_pengiriman) : 'belum_dikirim';
                        $custName = $order->user->name ?? 'Pelanggan';
                        $initials = strtoupper(substr($custName, 0, 2));
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors">
                        <!-- Order ID -->
                        <td class="py-4 px-4 font-mono font-bold text-gray-900">
                            #ORD-{{ \Carbon\Carbon::parse($order->tgl_pesan)->format('Y') }}-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Customer -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-[#EAEFE2] text-[#2D5A27] font-bold flex items-center justify-center text-[10px] shrink-0">
                                    {{ $initials }}
                                </div>
                                <span class="font-bold text-gray-900">{{ $custName }}</span>
                            </div>
                        </td>

                        <!-- Package -->
                        <td class="py-4 px-4 text-gray-700 font-medium">
                            {{ $paketItem->nm_paket ?? ($order->nama_acara ?? 'Nasi Box Nusantara') }}
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4">
                            @if($statusRaw === 'batal' || $statusRaw === 'dibatalkan' || $statusRaw === 'ditolak')
                                <span class="px-3 py-1 rounded-full bg-red-50 text-red-700 text-[10px] font-bold inline-block">
                                    Dibatalkan
                                </span>
                            @elseif($statusRaw === 'selesai' || $shipStatus === 'sampai')
                                <span class="px-3 py-1 rounded-full bg-[#EAEFE2] text-[#3B420C] text-[10px] font-bold inline-block">
                                    Selesai
                                </span>
                            @elseif($shipStatus === 'dikirim')
                                <span class="px-3 py-1 rounded-full bg-green-600 text-white text-[10px] font-bold inline-block">
                                    Dikirim
                                </span>
                            @elseif($prodStatus === 'diproses')
                                <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold inline-block">
                                    Diproses
                                </span>
                            @elseif($statusRaw === 'disetujui' || $statusRaw === 'dikonfirmasi')
                                <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold inline-block">
                                    Dikonfirmasi
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-[#FDF0ED] text-[#8A3017] text-[10px] font-bold inline-block">
                                    Menunggu DP
                                </span>
                            @endif
                        </td>

                        <!-- Total -->
                        <td class="py-4 px-4 font-bold font-serif text-right text-gray-900">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-400 font-light">
                            Belum ada pesanan terbaru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
