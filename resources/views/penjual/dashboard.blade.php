@extends('layouts.admin')

@section('title', 'Dashboard Overview - RASACI Kitchen Management')

@section('content')
<!-- 4 METRIC CARDS GRID -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
    <!-- Card 1: TOTAL ORDERS -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL ORDERS</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ number_format($totalOrdersCount > 0 ? $totalOrdersCount : 1284, 0, ',', '.') }}
            </div>
            <div class="flex items-center gap-1 text-xs font-bold text-green-600">
                <span>↗</span>
                <span>+12.5% vs last month</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-xl shrink-0">
            🛍️
        </div>
    </div>

    <!-- Card 2: REVENUE -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">REVENUE</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                Rp {{ $totalRevenueSum > 0 ? number_format($totalRevenueSum / 1000000, 1) . 'M' : '42.5M' }}
            </div>
            <div class="flex items-center gap-1 text-xs font-bold text-green-600">
                <span>↗</span>
                <span>+8.2% vs last month</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-xl shrink-0">
            💵
        </div>
    </div>

    <!-- Card 3: PENDING PAYMENTS -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">PENDING PAYMENTS</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $pendingPaymentsCount > 0 ? $pendingPaymentsCount : 12 }}
            </div>
            <div class="flex items-center gap-1 text-xs font-bold text-red-500">
                <span>!</span>
                <span>Requires attention</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-red-50 text-red-600 flex items-center justify-center text-xl shrink-0">
            ⏱️
        </div>
    </div>

    <!-- Card 4: DELIVERIES -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">DELIVERIES</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $todayDeliveriesCount > 0 ? $todayDeliveriesCount : 48 }}
            </div>
            <div class="flex items-center gap-1 text-xs font-medium text-gray-500">
                <span>🕒</span>
                <span>Scheduled today</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#F8F9F3] text-gray-700 flex items-center justify-center text-xl shrink-0">
            🚚
        </div>
    </div>
</div>

<!-- MIDDLE SECTION: WEEKLY SALES & KITCHEN CAPACITY -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
    <!-- Left: Penjualan Mingguan (Span 8) -->
    <div class="lg:col-span-8 bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs flex flex-col justify-between space-y-6">
        <div class="flex justify-between items-center">
            <div>
                <h3 class="text-2xl font-bold font-serif text-gray-900">Penjualan Mingguan</h3>
                <p class="text-xs text-gray-400 font-light mt-0.5">Weekly revenue breakdown</p>
            </div>
            <button type="button" class="px-4 py-2 bg-[#F8F9F3] border border-gray-200 rounded-xl text-xs font-bold text-gray-700 flex items-center gap-1.5 hover:bg-gray-100 transition-colors cursor-pointer">
                <span>This Week</span>
                <span>∨</span>
            </button>
        </div>

        <!-- SVG Bar Chart Visualization -->
        <div class="pt-6 pb-2 px-2 flex justify-between items-end gap-3 h-52">
            <!-- Mon -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#EAEFE2] group-hover:bg-[#2D5A27] transition-all rounded-t-xl" style="height: 45%;"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">MON</span>
            </div>
            <!-- Tue -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#EAEFE2] group-hover:bg-[#2D5A27] transition-all rounded-t-xl" style="height: 65%;"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">TUE</span>
            </div>
            <!-- Wed -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#EAEFE2] group-hover:bg-[#2D5A27] transition-all rounded-t-xl" style="height: 55%;"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">WED</span>
            </div>
            <!-- Thu (Peak Active Bar) -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#2D5A27] transition-all rounded-t-xl shadow-md" style="height: 85%;"></div>
                <span class="text-[10px] font-black text-gray-900 uppercase">THU</span>
            </div>
            <!-- Fri -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#EAEFE2] group-hover:bg-[#2D5A27] transition-all rounded-t-xl" style="height: 70%;"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">FRI</span>
            </div>
            <!-- Sat -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#EAEFE2] group-hover:bg-[#2D5A27] transition-all rounded-t-xl" style="height: 95%;"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">SAT</span>
            </div>
            <!-- Sun -->
            <div class="flex-1 flex flex-col items-center gap-2 group">
                <div class="w-full bg-[#EAEFE2] group-hover:bg-[#2D5A27] transition-all rounded-t-xl" style="height: 75%;"></div>
                <span class="text-[10px] font-bold text-gray-400 uppercase">SUN</span>
            </div>
        </div>
    </div>

    <!-- Right: Kitchen Capacity Card (Span 4) -->
    <div class="lg:col-span-4 bg-[#2D5A27] rounded-3xl p-6 sm:p-7 text-white flex flex-col justify-between space-y-6 shadow-md">
        <div class="space-y-2">
            <h3 class="text-2xl font-bold font-serif text-white">Kitchen Capacity</h3>
            <p class="text-xs text-white/80 font-light leading-relaxed">
                Current kitchen load is at 85% for upcoming RASACI events.
            </p>
        </div>

        <!-- Capacity Gauges -->
        <div class="space-y-5 pt-2">
            <!-- Gauge 1 -->
            <div class="bg-black/20 p-4 rounded-2xl border border-white/10 space-y-2">
                <div class="flex justify-between text-xs font-bold">
                    <span>Main Kitchen</span>
                    <span class="text-green-300">92%</span>
                </div>
                <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-green-400 rounded-full" style="width: 92%;"></div>
                </div>
            </div>

            <!-- Gauge 2 -->
            <div class="bg-black/20 p-4 rounded-2xl border border-white/10 space-y-2">
                <div class="flex justify-between text-xs font-bold">
                    <span>Pastry Station</span>
                    <span class="text-green-300">64%</span>
                </div>
                <div class="w-full h-2.5 bg-white/20 rounded-full overflow-hidden">
                    <div class="h-full bg-green-400 rounded-full" style="width: 64%;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- BOTTOM SECTION: PESANAN TERBARU TABLE -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <h3 class="text-2xl font-bold font-serif text-gray-900">Pesanan Terbaru</h3>
        <a href="{{ route('pesanan.index') }}" class="text-xs font-bold text-gray-600 hover:text-[#2D5A27] transition-colors">
            View All Orders
        </a>
    </div>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="bg-[#F8F9F3] text-gray-400 font-bold uppercase tracking-wider text-[10px]">
                    <th class="py-3 px-4 rounded-l-xl">ORDER ID</th>
                    <th class="py-3 px-4">CUSTOMER</th>
                    <th class="py-3 px-4">PACKAGE</th>
                    <th class="py-3 px-4">STATUS</th>
                    <th class="py-3 px-4">TOTAL</th>
                    <th class="py-3 px-4 text-right rounded-r-xl">ACTIONS</th>
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
                                    Cancelled
                                </span>
                            @elseif($statusRaw === 'selesai' || $shipStatus === 'sampai')
                                <span class="px-3 py-1 rounded-full bg-[#EAEFE2] text-[#3B420C] text-[10px] font-bold inline-block">
                                    Completed
                                </span>
                            @elseif($shipStatus === 'dikirim')
                                <span class="px-3 py-1 rounded-full bg-green-600 text-white text-[10px] font-bold inline-block">
                                    In Delivery
                                </span>
                            @elseif($prodStatus === 'diproses')
                                <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold inline-block">
                                    Preparing
                                </span>
                            @elseif($statusRaw === 'disetujui' || $statusRaw === 'dikonfirmasi')
                                <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold inline-block">
                                    Confirmed
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-[#FDF0ED] text-[#8A3017] text-[10px] font-bold inline-block">
                                    Pending Payment
                                </span>
                            @endif
                        </td>

                        <!-- Total -->
                        <td class="py-4 px-4 font-bold font-serif text-gray-900">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('penjual.orders.validasi', $order->id) }}" class="p-1.5 text-gray-500 hover:text-[#2D5A27] transition-colors" title="View Detail / Validasi">
                                    👁️
                                </a>
                                <button type="button" onclick="openSellerStatusModal({{ $order->id }}, '{{ $order->status_pesanan }}', '{{ $order->status_produksi }}', '{{ $shipStatus }}')" class="p-1.5 text-gray-500 hover:text-amber-600 transition-colors cursor-pointer" title="Edit Status Timeline">
                                    ✏️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-8 text-center text-gray-400 font-light">
                            Belum ada pesanan terbaru.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<!-- EDIT STATUS MODAL -->
<div id="sellerStatusModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <div>
                <span id="modalEditOrderCode" class="text-xs font-mono font-bold text-gray-500"></span>
                <h3 class="text-xl font-bold font-serif text-gray-900">Update Status Timeline Pesanan</h3>
            </div>
            <button onclick="closeSellerStatusModal()" class="text-gray-400 hover:text-gray-600 text-lg">✕</button>
        </div>

        <form id="sellerStatusForm" onsubmit="submitSellerStatus(event)" class="space-y-4 text-xs">
            <input type="hidden" id="editOrderId">

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">1. Status Konfirmasi Pesanan (Validasi)</label>
                <select id="editStatusPesanan" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium">
                    <option value="menunggu_validasi">Menunggu DP / Validasi</option>
                    <option value="disetujui">Setujui / Dikonfirmasi</option>
                    <option value="ditolak">Tolak Pesanan</option>
                    <option value="batal">Batalkan Pesanan</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">2. Status Dapur / Produksi</label>
                <select id="editStatusProduksi" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium">
                    <option value="belum_diproses">Belum Diproses</option>
                    <option value="diproses">Sedang Diproses (Memasak)</option>
                    <option value="selesai">Selesai Memasak</option>
                </select>
            </div>

            <div class="space-y-1.5">
                <label class="font-bold text-gray-700 block">3. Status Pengiriman / Shipping Timeline</label>
                <select id="editStatusPengiriman" class="w-full p-3 rounded-xl border border-gray-200 bg-gray-50 font-medium">
                    <option value="belum_dikirim">Belum Dikirim</option>
                    <option value="dikirim">Kurir Dikirim (In Transit)</option>
                    <option value="sampai">Sampai / Pesanan Tiba</option>
                </select>
            </div>

            <div class="pt-3 flex gap-2">
                <button type="submit" id="saveStatusSubmitBtn" class="flex-1 bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3 rounded-xl transition-all cursor-pointer shadow-md">
                    Simpan Perubahan
                </button>
                <button type="button" onclick="closeSellerStatusModal()" class="px-4 py-3 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition-all cursor-pointer">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openSellerStatusModal(orderId, currentStatus, currentProd, currentShip) {
        document.getElementById('editOrderId').value = orderId;
        document.getElementById('modalEditOrderCode').innerText = '#ORD-' + String(orderId).padStart(5, '0');
        if (currentStatus) document.getElementById('editStatusPesanan').value = currentStatus;
        if (currentProd) document.getElementById('editStatusProduksi').value = currentProd;
        if (currentShip) document.getElementById('editStatusPengiriman').value = currentShip;
        document.getElementById('sellerStatusModal').classList.remove('hidden');
    }

    function closeSellerStatusModal() {
        document.getElementById('sellerStatusModal').classList.add('hidden');
    }

    async function submitSellerStatus(e) {
        e.preventDefault();
        const orderId = document.getElementById('editOrderId').value;
        const statusPesanan = document.getElementById('editStatusPesanan').value;
        const statusProduksi = document.getElementById('editStatusProduksi').value;
        const statusPengiriman = document.getElementById('editStatusPengiriman').value;

        const btn = document.getElementById('saveStatusSubmitBtn');
        if (btn) btn.disabled = true;

        try {
            // 1. Update Validasi / Status Pesanan
            const resValidasi = await fetch(`/api/penjual/pesanan/${orderId}/validasi`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status_pesanan: statusPesanan })
            });
            const dataValidasi = await resValidasi.json();

            if (!resValidasi.ok) {
                const errMsg = dataValidasi.errors?.status_pesanan?.[0] || dataValidasi.message || 'Gagal mengupdate status konfirmasi.';
                alert(errMsg);
                if (btn) btn.disabled = false;
                return;
            }

            // 2. Update Produksi Dapur
            await fetch(`/api/penjual/pesanan/${orderId}/produksi`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status_produksi: statusProduksi })
            });

            // 3. Update Pengiriman / Shipping Status
            await fetch(`/api/penjual/pesanan/${orderId}/pengiriman`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ status_pengiriman: statusPengiriman })
            });

            window.location.reload();
        } catch (err) {
            alert('Terjadi kesalahan koneksi.');
            if (btn) btn.disabled = false;
        }
    }
</script>
@endsection
