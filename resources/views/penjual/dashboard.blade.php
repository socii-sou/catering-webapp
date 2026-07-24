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
            <div class="flex items-center gap-1 text-xs font-bold text-green-600">
                <span>📦</span>
                <span>Semua Pesanan Aktif</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-xl shrink-0">
            🛍️
        </div>
    </div>

    <!-- Card 2: TOTAL PENDAPATAN -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">TOTAL PENDAPATAN</span>
            <div class="text-xl sm:text-2xl font-extrabold font-serif text-gray-900 truncate">
                Rp {{ number_format($totalRevenueSum, 0, ',', '.') }}
            </div>
            <div class="flex items-center gap-1 text-xs font-bold text-green-600">
                <span>💵</span>
                <span>Total Omzet Aktif</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-xl shrink-0">
            💳
        </div>
    </div>

    <!-- Card 3: MENUNGGU VALIDASI -->
    <div class="bg-white rounded-3xl p-5 border border-[#E5E5DC] shadow-xs flex justify-between items-start hover:shadow-md transition-all">
        <div class="space-y-2">
            <span class="text-[10px] font-bold tracking-wider text-gray-400 uppercase">MENUNGGU VALIDASI</span>
            <div class="text-3xl font-extrabold font-serif text-gray-900">
                {{ $pendingPaymentsCount }}
            </div>
            <div class="flex items-center gap-1 text-xs font-bold {{ $pendingPaymentsCount > 0 ? 'text-amber-600' : 'text-green-600' }}">
                <span>⏱️</span>
                <span>{{ $pendingPaymentsCount > 0 ? 'Perlu Tindakan Penjual' : 'Semua Tervalidasi' }}</span>
            </div>
        </div>
        <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
            📋
        </div>
    </div>
</div>



<!-- BOTTOM SECTION: PESANAN TERBARU TABLE -->
<div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
    <div class="flex justify-between items-center border-b border-gray-100 pb-4">
        <h3 class="text-2xl font-bold font-serif text-gray-900">Pesanan Terbaru</h3>
        <a href="{{ route('penjual.orders') }}" class="text-xs font-bold text-gray-600 hover:text-[#2D5A27] transition-colors">
            Lihat Semua Pesanan
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
