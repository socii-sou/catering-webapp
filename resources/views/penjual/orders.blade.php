@extends('layouts.admin')

@section('title', 'Order Management - RASACI Kitchen Management')

@section('content')
<!-- TOP HEADER BAR & SEARCH -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
        <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight">Manajemen Pesanan</h1>
        <p class="text-xs text-gray-500 font-light mt-1">Kelola dan pantau seluruh pesanan catering yang masuk.</p>
    </div>

    <!-- Search Input & Filter Icon -->
    <div class="flex items-center gap-3">
        <div class="relative w-64">
            <span class="absolute inset-y-0 left-3.5 flex items-center text-gray-400 text-sm">🔍</span>
            <input type="text" id="orderSearchInput" onkeyup="filterOrdersTable()" placeholder="Cari pesanan..." class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-xl text-xs font-medium focus:outline-none focus:border-[#2D5A27] shadow-2xs">
        </div>
        <button type="button" class="p-2.5 bg-white border border-gray-200 rounded-xl text-gray-600 hover:bg-gray-50 transition-colors shadow-2xs cursor-pointer">
            ⚡
        </button>
    </div>
</div>

<!-- 4 METRIC SUMMARY CARDS GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Card 1: TOTAL PESANAN -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL PESANAN</span>
        <div class="flex items-center justify-between">
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $totalOrders }}
            </div>
            <span class="text-xs font-bold text-green-600 flex items-center gap-0.5">
                <span>📦</span> Semua Pesanan
            </span>
        </div>
    </div>

    <!-- Card 2: MENUNGGU VALIDASI -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">MENUNGGU VALIDASI</span>
        <div class="flex items-center justify-between">
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $pendingValidationCount }}
            </div>
            @if($pendingValidationCount > 0)
                <span class="px-2 py-0.5 rounded-md bg-amber-100 text-amber-700 text-[10px] font-extrabold tracking-wider uppercase">
                    PERLU TINDAKAN
                </span>
            @else
                <span class="px-2 py-0.5 rounded-md bg-green-100 text-green-700 text-[10px] font-extrabold tracking-wider uppercase">
                    TERVALIDASI
                </span>
            @endif
        </div>
    </div>

    <!-- Card 3: SEDANG DIPROSES -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">SEDANG DIPROSES</span>
        <div class="flex items-center justify-between">
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $inPreparationCount }}
            </div>
            <span class="text-[11px] font-medium text-gray-500">
                🍳 Dapur Masak
            </span>
        </div>
    </div>

    <!-- Card 4: TOTAL PENDAPATAN -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs space-y-2 hover:shadow-md transition-all">
        <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL PENDAPATAN</span>
        <div class="flex items-center justify-between">
            <div class="text-xl sm:text-2xl font-extrabold font-serif text-gray-900 truncate">
                Rp {{ number_format($todayRevenueSum, 0, ',', '.') }}
            </div>
            <span class="text-[11px] font-bold text-green-600 shrink-0">
                Omzet Aktif
            </span>
        </div>
    </div>
</div>

<!-- MAIN ORDERS MANAGEMENT CONTAINER -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <!-- FILTER TABS -->
    <div class="border-b border-gray-200 flex items-center gap-8 text-xs font-bold text-gray-500 overflow-x-auto pb-0.5">
        <button type="button" onclick="filterByTab('semua', this)" class="order-tab-btn border-b-2 border-[#2D5A27] text-gray-900 pb-3 transition-all cursor-pointer">
            Semua
        </button>
        <button type="button" onclick="filterByTab('menunggu_validasi', this)" class="order-tab-btn border-b-2 border-transparent hover:text-gray-900 pb-3 transition-all cursor-pointer">
            Menunggu Validasi
        </button>
        <button type="button" onclick="filterByTab('diproses', this)" class="order-tab-btn border-b-2 border-transparent hover:text-gray-900 pb-3 transition-all cursor-pointer">
            Diproses (Di Masak)
        </button>
        <button type="button" onclick="filterByTab('dikirim', this)" class="order-tab-btn border-b-2 border-transparent hover:text-gray-900 pb-3 transition-all cursor-pointer">
            Dikirim (Di Antar)
        </button>
        <button type="button" onclick="filterByTab('selesai', this)" class="order-tab-btn border-b-2 border-transparent hover:text-gray-900 pb-3 transition-all cursor-pointer">
            Selesai
        </button>
    </div>

    <!-- DATA TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">ID PESANAN</th>
                    <th class="py-3 px-4">PELANGGAN</th>
                    <th class="py-3 px-4">TANGGAL</th>
                    <th class="py-3 px-4">TOTAL HARGA</th>
                    <th class="py-3 px-4">STATUS PEMBAYARAN</th>
                    <th class="py-3 px-4">STATUS PESANAN</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">AKSI</th>
                </tr>
            </thead>
            <tbody id="ordersTableBody" class="divide-y divide-gray-100 font-medium">
                @forelse($orders as $order)
                    @php
                        $statusRaw = strtolower($order->status_pesanan);
                        $prodStatus = strtolower($order->status_produksi);
                        $shipStatus = $order->pengiriman ? strtolower($order->pengiriman->status_pengiriman) : 'belum_dikirim';
                        $hasPayments = $order->pembayarans && $order->pembayarans->count() > 0;
                        $lastPayment = $order->pembayarans->last();
                        $statusBayar = $lastPayment ? strtolower($lastPayment->status_bayar) : 'menunggu_dp';

                        $custName = $order->user->name ?? 'Pelanggan';
                        $initials = strtoupper(substr($custName, 0, 2));

                        // Payment Status pill logic
                        $paymentPillText = 'Pending';
                        $paymentPillBg = 'bg-amber-100 text-amber-800';
                        if ($statusBayar === 'lunas') {
                            $paymentPillText = 'Lunas';
                            $paymentPillBg = 'bg-green-100 text-green-800';
                        } elseif ($statusBayar === 'diverifikasi' || $statusBayar === 'dp_diterima' || $statusRaw === 'disetujui' || $hasPayments) {
                            $paymentPillText = 'Dikonfirmasi';
                            $paymentPillBg = 'bg-emerald-100 text-emerald-800';
                        }

                        // Order Status pill logic
                        $orderPillText = 'Waiting Validation';
                        $orderPillBg = 'bg-[#EAEFE2] text-gray-700';

                        if ($statusRaw === 'batal' || $statusRaw === 'dibatalkan' || $statusRaw === 'ditolak') {
                            $orderPillText = 'Cancelled';
                            $orderPillBg = 'bg-red-100 text-red-800';
                        } elseif ($statusRaw === 'selesai' || $shipStatus === 'sampai') {
                            $orderPillText = 'Delivered';
                            $orderPillBg = 'bg-green-800 text-white';
                        } elseif ($shipStatus === 'dikirim') {
                            $orderPillText = 'With Courier';
                            $orderPillBg = 'bg-[#3B420C] text-white';
                        } elseif ($prodStatus === 'diproses') {
                            $orderPillText = 'In Kitchen';
                            $orderPillBg = 'bg-[#EBF5E8] text-[#2D5A27]';
                        } elseif ($statusRaw === 'disetujui' || $statusRaw === 'dikonfirmasi') {
                            $orderPillText = 'Dikonfirmasi';
                            $orderPillBg = 'bg-[#EBF5E8] text-[#2D5A27]';
                        }
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors order-row" 
                        data-status-pesanan="{{ $statusRaw }}" 
                        data-status-produksi="{{ $prodStatus }}" 
                        data-status-pengiriman="{{ $shipStatus }}"
                        data-name="{{ strtolower($custName) }}"
                        data-id="{{ $order->id }}">
                        
                        <!-- Order ID -->
                        <td class="py-4 px-4 font-mono font-bold text-gray-900">
                            #ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
                        </td>

                        <!-- Customer -->
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-[10px] shrink-0">
                                    {{ $initials }}
                                </div>
                                <span class="font-bold text-gray-900">{{ $custName }}</span>
                            </div>
                        </td>

                        <!-- Date -->
                        <td class="py-4 px-4 text-gray-500 font-light">
                            {{ \Carbon\Carbon::parse($order->tgl_pesan)->format('M d, Y') }}
                        </td>

                        <!-- Total -->
                        <td class="py-4 px-4 font-serif font-bold text-gray-900">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>

                        <!-- Payment Status -->
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold inline-block {{ $paymentPillBg }}">
                                {{ $paymentPillText }}
                            </span>
                        </td>

                        <!-- Order Status -->
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold inline-block {{ $orderPillBg }}">
                                {{ $orderPillText }}
                            </span>
                        </td>

                        <!-- Action Buttons -->
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-xs">
                                <!-- Action 1: Validasi Pembayaran Page -->
                                <a href="{{ route('penjual.orders.validasi', $order->id) }}" class="font-bold text-green-700 hover:text-green-900 hover:underline cursor-pointer">
                                    Detail Pembayaran
                                </a>

                                <!-- Action 2: Update Status -->
                                <button type="button" onclick="openUpdateStatusOrderModal({{ $order->id }}, '{{ $statusRaw }}', '{{ $prodStatus }}', '{{ $shipStatus }}')" class="font-bold text-[#2D5A27] hover:text-green-900 hover:underline cursor-pointer">
                                    Update Status
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <!-- Static Fallback Rows matching screenshot design -->
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 font-mono font-bold text-gray-900">#ORD-8821</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-[10px] shrink-0">AS</div>
                                <span class="font-bold text-gray-900">Andi Saputra</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-gray-500 font-light">Oct 24, 2024</td>
                        <td class="py-4 px-4 font-serif font-bold text-gray-900">Rp 1.250.000</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-[10px] font-bold inline-block">Pending</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full bg-[#EAEFE2] text-gray-700 text-[10px] font-bold inline-block">Waiting Validation</span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-xs">
                                <button type="button" onclick="openValidasiPembayaranModal(8821, 'Pending')" class="font-bold text-green-700 hover:underline">Validasi Pembayaran</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 font-mono font-bold text-gray-900">#ORD-8820</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-green-100 text-green-800 font-bold flex items-center justify-center text-[10px] shrink-0">MW</div>
                                <span class="font-bold text-gray-900">Maria Wijaya</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-gray-500 font-light">Oct 24, 2024</td>
                        <td class="py-4 px-4 font-serif font-bold text-gray-900">Rp 450.000</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold inline-block">Paid</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold inline-block">In Kitchen</span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-xs">
                                <button type="button" onclick="openUpdateStatusOrderModal(8820, 'disetujui', 'diproses', 'belum_dikirim')" class="font-bold text-[#2D5A27] hover:underline">Update Status</button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-4 font-mono font-bold text-gray-900">#ORD-8819</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-bold flex items-center justify-center text-[10px] shrink-0">BK</div>
                                <span class="font-bold text-gray-900">Budi Kusuma</span>
                            </div>
                        </td>
                        <td class="py-4 px-4 text-gray-500 font-light">Oct 23, 2024</td>
                        <td class="py-4 px-4 font-serif font-bold text-gray-900">Rp 890.000</td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full bg-green-100 text-green-800 text-[10px] font-bold inline-block">Paid</span>
                        </td>
                        <td class="py-4 px-4">
                            <span class="px-3 py-1 rounded-full bg-[#3B420C] text-white text-[10px] font-bold inline-block">With Courier</span>
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-3 text-xs">
                                <button type="button" onclick="openUpdateStatusOrderModal(8819, 'disetujui', 'selesai', 'dikirim')" class="font-bold text-[#2D5A27] hover:underline">Update Status</button>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION FOOTER -->
    <div class="pt-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-gray-500 font-medium">
        <div>
            Showing 1-{{ count($orders) }} of {{ $totalOrders }} orders
        </div>
        <div class="flex items-center gap-1">
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-400 hover:bg-gray-50 flex items-center justify-center font-bold">‹</button>
            <button type="button" class="w-8 h-8 rounded-xl bg-[#2D5A27] text-white flex items-center justify-center font-bold shadow-xs">1</button>
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 flex items-center justify-center font-bold">2</button>
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 flex items-center justify-center font-bold">3</button>
            <button type="button" class="w-8 h-8 rounded-xl border border-gray-200 text-gray-600 hover:bg-gray-50 flex items-center justify-center font-bold">›</button>
        </div>
    </div>
</div>
@endsection

@section('modals')
<!-- MODAL 1: VALIDASI PEMBAYARAN -->
<div id="validasiPembayaranModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <div>
                <span id="validasiOrderCode" class="text-xs font-mono font-bold text-gray-500"></span>
                <h3 class="text-xl font-bold font-serif text-gray-900">Validasi Pembayaran</h3>
            </div>
            <button onclick="closeValidasiPembayaranModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="validasiPembayaranForm" onsubmit="submitValidasiPembayaran(event)" class="space-y-4 text-xs">
            <input type="hidden" id="validasiOrderId">

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Pilih Status Pembayaran</label>
                <select id="selectStatusBayar" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium">
                    <option value="dikonfirmasi">Dikonfirmasi (DP 50% Diverifikasi)</option>
                    <option value="lunas">Lunas (100% Lunas Seluruhnya)</option>
                    <option value="menunggu_dp">Menunggu DP / Reset</option>
                </select>
            </div>

            <div class="p-4 bg-[#F8F9F3] rounded-2xl border border-gray-200 space-y-2">
                <span class="font-bold text-gray-700 block text-[11px]">Catatan Konfirmasi Penjual:</span>
                <p class="text-[11px] text-gray-600 font-light leading-relaxed">
                    Mengubah status menjadi <strong>Dikonfirmasi</strong> akan menandai DP 50% telah diterima dan pesanan disetujui. Mengubah menjadi <strong>Lunas</strong> akan menandai seluruh pembayaran telah selasai.
                </p>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="submit" id="btnSubmitValidasiBayar" class="flex-1 bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3.5 rounded-xl transition-all cursor-pointer shadow-md">
                    Simpan Status Pembayaran
                </button>
                <button type="button" onclick="closeValidasiPembayaranModal()" class="px-4 py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 2: UPDATE STATUS ORDERAN -->
<div id="updateStatusOrderModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <div>
                <span id="updateOrderCode" class="text-xs font-mono font-bold text-gray-500"></span>
                <h3 class="text-xl font-bold font-serif text-gray-900">Update Status Order</h3>
            </div>
            <button onclick="closeUpdateStatusOrderModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="updateStatusOrderForm" onsubmit="submitUpdateStatusOrder(event)" class="space-y-4 text-xs">
            <input type="hidden" id="updateOrderId">

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">Status Tahapan Orderan</label>
                <select id="selectStageOrder" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium">
                    <option value="menunggu_validasi">Menunggu Validasi</option>
                    <option value="dikonfirmasi">Dikonfirmasi (Pesanan Disetujui)</option>
                    <option value="di_masak">Di Masak (Sedang Diproses Dapur)</option>
                    <option value="di_antar">Di Antar (Kurir Sedang Mengirim)</option>
                    <option value="selesai">Selesai (Tiba di Lokasi)</option>
                    <option value="batal">Dibatalkan / Ditolak</option>
                </select>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="submit" id="btnSubmitUpdateOrder" class="flex-1 bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3.5 rounded-xl transition-all cursor-pointer shadow-md">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeUpdateStatusOrderModal()" class="px-4 py-3.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>

<!-- MODAL 3: ERROR / WARNING NOTIFICATION MODAL -->
<div id="errorAlertModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-60 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <!-- Warning Icon -->
        <div class="w-16 h-16 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto text-3xl border border-red-100">
            ⚠️
        </div>
        
        <div class="space-y-2">
            <h3 class="text-xl font-bold font-serif text-gray-900">Peringatan</h3>
            <p id="errorAlertMessage" class="text-xs text-gray-600 font-light leading-relaxed"></p>
        </div>

        <div class="pt-2">
            <button type="button" onclick="closeErrorAlertModal()" class="w-full bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3.5 rounded-xl transition-all cursor-pointer shadow-md text-xs">
                Mengerti
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentTabFilter = 'semua';

    function filterByTab(tab, btnElement) {
        currentTabFilter = tab;
        
        document.querySelectorAll('.order-tab-btn').forEach(btn => {
            btn.className = "order-tab-btn border-b-2 border-transparent hover:text-gray-900 pb-3 transition-all cursor-pointer text-gray-500";
        });
        if (btnElement) {
            btnElement.className = "order-tab-btn border-b-2 border-[#2D5A27] text-gray-900 pb-3 transition-all cursor-pointer font-bold";
        }

        filterOrdersTable();
    }

    function filterOrdersTable() {
        const query = document.getElementById('orderSearchInput').value.toLowerCase();
        const rows = document.querySelectorAll('.order-row');

        rows.forEach(row => {
            const name = row.getAttribute('data-name') || '';
            const id = row.getAttribute('data-id') || '';
            const statusPesanan = row.getAttribute('data-status-pesanan') || '';
            const statusProduksi = row.getAttribute('data-status-produksi') || '';
            const statusPengiriman = row.getAttribute('data-status-pengiriman') || '';

            const matchQuery = name.includes(query) || id.includes(query);

            let matchTab = true;
            if (currentTabFilter === 'menunggu_validasi') {
                matchTab = (statusPesanan === 'menunggu_validasi');
            } else if (currentTabFilter === 'diproses') {
                matchTab = (statusProduksi === 'diproses');
            } else if (currentTabFilter === 'dikirim') {
                matchTab = (statusPengiriman === 'dikirim');
            } else if (currentTabFilter === 'selesai') {
                matchTab = (statusPesanan === 'selesai' || statusPengiriman === 'sampai');
            }

            row.style.display = (matchQuery && matchTab) ? '' : 'none';
        });
    }

    // MODAL 1: VALIDASI PEMBAYARAN
    function openValidasiPembayaranModal(orderId, currentPaymentPill) {
        document.getElementById('validasiOrderId').value = orderId;
        document.getElementById('validasiOrderCode').innerText = '#ORD-' + String(orderId).padStart(4, '0');
        
        if (currentPaymentPill === 'Lunas') {
            document.getElementById('selectStatusBayar').value = 'lunas';
        } else if (currentPaymentPill === 'Dikonfirmasi') {
            document.getElementById('selectStatusBayar').value = 'dikonfirmasi';
        } else {
            document.getElementById('selectStatusBayar').value = 'dikonfirmasi';
        }

        document.getElementById('validasiPembayaranModal').classList.remove('hidden');
    }

    function closeValidasiPembayaranModal() {
        document.getElementById('validasiPembayaranModal').classList.add('hidden');
    }

    async function submitValidasiPembayaran(e) {
        e.preventDefault();
        const orderId = document.getElementById('validasiOrderId').value;
        const statusBayar = document.getElementById('selectStatusBayar').value;

        try {
            const res = await fetch(`/api/penjual/pesanan/${orderId}/pembayaran`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status_bayar: statusBayar })
            });

            if (res.ok) {
                window.location.reload();
            } else {
                const data = await res.json();
                showErrorAlert(data.message || 'Gagal mengubah status pembayaran.');
            }
        } catch(err) {
            showErrorAlert('Terjadi kesalahan jaringan.');
        }
    }

    // MODAL 2: UPDATE STATUS ORDER
    function openUpdateStatusOrderModal(orderId, statusRaw, prodStatus, shipStatus) {
        document.getElementById('updateOrderId').value = orderId;
        document.getElementById('updateOrderCode').innerText = '#ORD-' + String(orderId).padStart(4, '0');

        const select = document.getElementById('selectStageOrder');
        if (statusRaw === 'ditolak' || statusRaw === 'batal') {
            select.value = 'batal';
        } else if (statusRaw === 'selesai' || shipStatus === 'sampai') {
            select.value = 'selesai';
        } else if (shipStatus === 'dikirim') {
            select.value = 'di_antar';
        } else if (prodStatus === 'diproses') {
            select.value = 'di_masak';
        } else if (statusRaw === 'disetujui' || statusRaw === 'dikonfirmasi') {
            select.value = 'dikonfirmasi';
        } else {
            select.value = 'menunggu_validasi';
        }

        document.getElementById('updateStatusOrderModal').classList.remove('hidden');
    }

    function closeUpdateStatusOrderModal() {
        document.getElementById('updateStatusOrderModal').classList.add('hidden');
    }

    async function submitUpdateStatusOrder(e) {
        e.preventDefault();
        const orderId = document.getElementById('updateOrderId').value;
        const stage = document.getElementById('selectStageOrder').value;

        try {
            const res = await fetch(`/penjual/orders/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ stage: stage })
            });

            const data = await res.json();
            if (res.ok && data.success) {
                window.location.reload();
            } else {
                showErrorAlert(data.message || 'Gagal mengupdate status order.');
            }
        } catch(err) {
            showErrorAlert('Terjadi kesalahan saat mengupdate status order.');
        }
    }

    function showErrorAlert(message) {
        closeUpdateStatusOrderModal();
        closeValidasiPembayaranModal();
        document.getElementById('errorAlertMessage').innerText = message;
        document.getElementById('errorAlertModal').classList.remove('hidden');
    }

    function closeErrorAlertModal() {
        document.getElementById('errorAlertModal').classList.add('hidden');
    }
</script>
@endsection
