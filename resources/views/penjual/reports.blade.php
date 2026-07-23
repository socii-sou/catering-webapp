@extends('layouts.admin')

@section('title', 'Laporan Penjualan - RASACI Kitchen Management')

@section('content')
<!-- TOP HEADER BAR & CONTROLS -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <span class="text-xs text-gray-400 font-bold tracking-wider uppercase block">Laporan › Analisis Penjualan</span>
        <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight mt-0.5">Laporan Penjualan</h1>
    </div>

    <!-- Date Range Selector & PDF Export Button -->
    <div class="flex items-center gap-3">
        <div class="relative">
            <select id="reportDateRange" class="appearance-none bg-white border border-gray-200 rounded-xl px-4 py-2.5 pr-8 text-xs font-bold text-gray-700 shadow-2xs focus:outline-none focus:border-[#2D5A27] cursor-pointer">
                <option value="oct">📅 Bulan Ini (Aktif)</option>
                <option value="ytd">📅 Tahun Ke Tahun (YTD)</option>
            </select>
            <span class="absolute inset-y-0 right-3 flex items-center text-gray-400 pointer-events-none text-xs">∨</span>
        </div>

        <button type="button" onclick="window.print()" class="bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-2.5 px-5 rounded-xl shadow-md text-xs flex items-center gap-2 transition-all cursor-pointer">
            <span>📥</span>
            <span>Unduh Laporan (PDF/CSV)</span>
        </button>
    </div>
</div>

<!-- 3 METRIC SUMMARY CARDS GRID -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
    <!-- Card 1: TOTAL PENJUALAN -->
    <div class="bg-white rounded-3xl p-6 border border-[#E5E5DC] shadow-xs space-y-4 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 flex items-center justify-center text-lg">
                💵
            </div>
            <span class="text-xs font-bold text-green-600 flex items-center gap-0.5">
                <span>↗</span> Omzet Real
            </span>
        </div>
        <div>
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block">TOTAL PENJUALAN</span>
            <div class="text-xl sm:text-2xl font-extrabold font-serif text-gray-900 mt-1 truncate">
                Rp {{ number_format($totalSalesSum, 0, ',', '.') }}
            </div>
        </div>
    </div>

    <!-- Card 2: PAKET TERFAVORIT -->
    <div class="bg-white rounded-3xl p-6 border border-[#E5E5DC] shadow-xs space-y-4 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-2xl bg-green-100 text-green-800 flex items-center justify-center text-lg">
                ⭐
            </div>
            <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-800 text-[10px] font-extrabold uppercase">
                Terlaris
            </span>
        </div>
        <div>
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block">PAKET TERFAVORIT</span>
            <div class="text-lg font-bold font-serif text-gray-900 mt-1 leading-snug line-clamp-1">
                {{ $popularPaketName }}
            </div>
        </div>
    </div>

    <!-- Card 3: RATA-RATA PESANAN -->
    <div class="bg-white rounded-3xl p-6 border border-[#E5E5DC] shadow-xs space-y-4 hover:shadow-md transition-all">
        <div class="flex items-center justify-between">
            <div class="w-10 h-10 rounded-2xl bg-orange-100 text-orange-800 flex items-center justify-center text-lg">
                🛍️
            </div>
            <span class="text-xs font-medium text-gray-400">
                Per Pesanan
            </span>
        </div>
        <div>
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase block">RATA-RATA PESANAN</span>
            <div class="text-xl sm:text-2xl font-extrabold font-serif text-gray-900 mt-1 truncate">
                Rp {{ number_format($avgOrderValue, 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

<!-- MIDDLE SECTION: MONTHLY SALES GROWTH STACKED BAR CHART -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h3 class="text-2xl font-bold font-serif text-gray-900">Pertumbuhan Penjualan Bulanan</h3>
            <p class="text-xs text-gray-400 font-light mt-0.5">Performa grafik pendapatan riil 6 bulan terakhir</p>
        </div>

        <!-- Legend Indicators -->
        <div class="flex items-center gap-4 text-xs font-medium text-gray-600">
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-[#2D5A27]"></span>
                <span>Bulan Aktif / Peak</span>
            </div>
            <div class="flex items-center gap-1.5">
                <span class="w-3 h-3 rounded-full bg-[#C3D9A5]"></span>
                <span>Pendapatan Real</span>
            </div>
        </div>
    </div>

    <!-- Stacked Bar Chart Visualization -->
    <div class="pt-8 pb-3 px-4 flex justify-between items-end gap-4 sm:gap-6 h-64 border-b border-gray-100">
        @foreach($monthlyGrowth as $item)
            @php
                $barHeightPct = $maxMonthlyRevenue > 0 ? max(round(($item['revenue'] / $maxMonthlyRevenue) * 100), $item['revenue'] > 0 ? 12 : 6) : 6;
            @endphp
            <div class="flex-1 flex flex-col items-center gap-2 group relative">
                <!-- Hover Tooltip -->
                <div class="opacity-0 group-hover:opacity-100 transition-opacity bg-gray-900 text-white text-[10px] font-bold py-1 px-2.5 rounded-lg absolute -top-9 whitespace-nowrap shadow-md pointer-events-none z-20">
                    Rp {{ number_format($item['revenue'], 0, ',', '.') }}
                </div>

                <div class="w-full max-w-[48px] flex flex-col justify-end h-full">
                    <div class="w-full {{ $item['is_current'] ? 'bg-[#2D5A27] shadow-md' : 'bg-[#C3D9A5] group-hover:bg-[#2D5A27]' }} rounded-t-lg transition-all" style="height: {{ $barHeightPct }}%;"></div>
                </div>
                <span class="text-[10px] {{ $item['is_current'] ? 'font-black text-gray-900' : 'font-bold text-gray-400' }} uppercase">
                    {{ $item['month'] }}
                </span>
            </div>
        @endforeach
    </div>
</div>

<!-- BOTTOM SECTION: RECENT TRANSACTIONS TABLE -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <h3 class="text-2xl font-bold font-serif text-gray-900">Transaksi Terkini</h3>
        
        <!-- Search Input -->
        <div class="relative w-full sm:w-64">
            <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 text-sm">🔍</span>
            <input type="text" id="trxSearchInput" onkeyup="filterTransactionsTable()" placeholder="Cari transaksi..." class="w-full pl-10 pr-4 py-2 bg-[#F8F9F3] border border-gray-200 rounded-xl text-xs font-medium focus:outline-none focus:bg-white shadow-2xs">
        </div>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">ID TRANSAKSI</th>
                    <th class="py-3 px-4">TANGGAL</th>
                    <th class="py-3 px-4">PELANGGAN</th>
                    <th class="py-3 px-4">PAKET</th>
                    <th class="py-3 px-4">STATUS</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">NOMINAL</th>
                </tr>
            </thead>
            <tbody id="trxTableBody" class="divide-y divide-gray-100 font-medium">
                @forelse($transactions as $trx)
                    @php
                        $paketTitle = $trx->pesananPaket->first()?->paket->nm_paket ?? ($trx->nama_acara ?? 'Royal Wedding Buffet');
                        $statusRaw = strtolower($trx->status_pesanan);
                        $custName = $trx->user->name ?? 'Pelanggan';

                        $badgeText = 'Selesai';
                        $badgeBg = 'bg-[#EBF5E8] text-[#2D5A27]';
                        if ($statusRaw === 'batal' || $statusRaw === 'ditolak') {
                            $badgeText = 'Dibatalkan';
                            $badgeBg = 'bg-red-100 text-red-800';
                        } elseif ($statusRaw === 'menunggu_validasi') {
                            $badgeText = 'Menunggu Validasi';
                            $badgeBg = 'bg-amber-100 text-amber-800';
                        }
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors trx-row" data-name="{{ strtolower($custName) }}" data-id="{{ $trx->id }}" data-paket="{{ strtolower($paketTitle) }}">
                        <!-- Transaction ID -->
                        <td class="py-4 px-4 font-mono font-bold text-gray-900">
                            #TRX-{{ str_pad($trx->id + 84800, 5, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Date -->
                        <td class="py-4 px-4 text-gray-500 font-light">
                            {{ \Carbon\Carbon::parse($trx->tgl_pesan)->format('M d, Y') }}
                        </td>

                        <!-- Customer -->
                        <td class="py-4 px-4 font-bold text-gray-900">
                            {{ $custName }}
                        </td>

                        <!-- Package -->
                        <td class="py-4 px-4 text-gray-700">
                            {{ $paketTitle }}
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold inline-block {{ $badgeBg }}">
                                {{ $badgeText }}
                            </span>
                        </td>

                        <!-- Amount -->
                        <td class="py-4 px-4 text-right font-serif font-bold text-gray-900">
                            Rp {{ number_format($trx->total_harga, 0, ',', '.') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 font-medium">
                            Belum ada data transaksi penjualan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION FOOTER -->
    @if($transactions->total() > 0)
        <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 font-medium">
            <div>
                Menampilkan {{ $transactions->firstItem() ?? 0 }} - {{ $transactions->lastItem() ?? 0 }} dari {{ $transactions->total() }} transaksi
            </div>
            <div>
                {{ $transactions->links() }}
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function filterTransactionsTable() {
        const query = document.getElementById('trxSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.trx-row');

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const id = row.getAttribute('data-id') || '';
            const paket = row.getAttribute('data-paket') || '';

            const matchQuery = name.includes(query) || id.includes(query) || paket.includes(query);
            row.style.display = matchQuery ? '' : 'none';
        });
    }
</script>
@endsection
