@extends('layouts.app')

@section('title', 'Pesanan Saya - RASACI Catering')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8 min-h-[75vh]">

    <!-- PAGE HEADER -->
    <div class="space-y-2">
        <h1 class="text-4xl sm:text-5xl font-serif font-normal text-gray-900 tracking-tight">
            Pesanan Saya
        </h1>
        <p class="text-sm sm:text-base text-gray-600 font-light">
            Pantau status pesanan catering Anda secara real-time.
        </p>
    </div>

    <!-- STATUS FILTER TABS -->
    <div class="border-b border-[#E5E5DC]">
        <nav class="flex space-x-8 text-sm font-medium" aria-label="Tabs">
            <button onclick="filterOrders('semua', this)" class="order-tab active-tab pb-3 text-[#2D5A27] border-b-2 border-[#2D5A27] font-bold cursor-pointer transition-colors">
                Semua
            </button>
            <button onclick="filterOrders('berlangsung', this)" class="order-tab pb-3 text-gray-500 hover:text-gray-800 border-b-2 border-transparent cursor-pointer transition-colors">
                Berlangsung
            </button>
            <button onclick="filterOrders('selesai', this)" class="order-tab pb-3 text-gray-500 hover:text-gray-800 border-b-2 border-transparent cursor-pointer transition-colors">
                Selesai
            </button>
            <button onclick="filterOrders('dibatalkan', this)" class="order-tab pb-3 text-gray-500 hover:text-gray-800 border-b-2 border-transparent cursor-pointer transition-colors">
                Dibatalkan
            </button>
        </nav>
    </div>

    <!-- ORDERS LIST CONTAINER -->
    <div id="ordersList" class="space-y-5">
        @forelse($myOrders as $order)
            @php
                $firstPaket = $order->pesananPaket->first()?->paket;
                $heroImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300';
                if ($firstPaket && str_contains(strtolower($firstPaket->nm_paket), 'prasmanan')) {
                    $heroImage = 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=300';
                } elseif ($firstPaket && str_contains(strtolower($firstPaket->nm_paket), 'tumpeng')) {
                    $heroImage = 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?auto=format&fit=crop&q=80&w=300';
                }

                $status = strtolower($order->status_pesanan);
                $categoryGroup = 'berlangsung';
                if (in_array($status, ['selesai', 'completed'])) {
                    $categoryGroup = 'selesai';
                } elseif (in_array($status, ['batal', 'dibatalkan', 'ditolak', 'cancelled'])) {
                    $categoryGroup = 'dibatalkan';
                }

                $orderCode = '#NSL-' . str_pad($order->id, 8, '0', STR_PAD_LEFT);
            @endphp

            <!-- ORDER CARD ITEM -->
            <div class="order-card-item bg-white rounded-3xl p-5 sm:p-6 border border-[#E5E5DC] shadow-xs hover:shadow-md transition-all flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6"
                 data-category="{{ $categoryGroup }}">

                <!-- Left Info Section -->
                <div class="flex items-start gap-4 sm:gap-5 min-w-0 flex-1">
                    <img src="{{ $heroImage }}" alt="Paket Image" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border border-gray-100 shrink-0">
                    <div class="space-y-1.5 min-w-0">
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <span class="text-xs font-mono font-bold text-gray-500">{{ $orderCode }}</span>

                            @if(in_array($status, ['dikonfirmasi', 'disetujui', 'diproses', 'menunggu_validasi']))
                                <span class="px-2.5 py-0.5 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-bold">
                                    Dikonfirmasi
                                </span>
                            @elseif($status === 'selesai')
                                <span class="px-2.5 py-0.5 rounded-full bg-[#EAEFE2] text-[#3B420C] text-[10px] font-bold">
                                    Selesai
                                </span>
                            @elseif($status === 'batal' || $status === 'dibatalkan' || $status === 'ditolak')
                                <span class="px-2.5 py-0.5 rounded-full bg-red-50 text-red-700 text-[10px] font-bold">
                                    Dibatalkan
                                </span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full bg-[#FDF0ED] text-[#8A3017] text-[10px] font-bold">
                                    Menunggu DP
                                </span>
                            @endif
                        </div>

                        <h3 class="text-lg sm:text-xl font-bold font-serif text-gray-900 truncate">
                            {{ $firstPaket ? $firstPaket->nm_paket : ($order->nama_acara ?? 'Pesanan Catering') }} ({{ $order->jumlah_pax }} Pax)
                        </h3>

                        <p class="text-xs text-gray-500 flex items-center gap-1.5 font-light">
                            <span>📅</span>
                            <span>{{ \Carbon\Carbon::parse($order->tgl_acara)->translatedFormat('d F Y') }}</span>
                        </p>
                    </div>
                </div>

                <!-- Right Price & Action Section -->
                <div class="flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto pt-4 sm:pt-0 border-t sm:border-t-0 border-gray-100 gap-3">
                    <div class="text-left sm:text-right">
                        <span class="block text-[11px] text-gray-400 font-light">Total Pembayaran</span>
                        <span class="text-xl sm:text-2xl font-bold font-serif text-gray-900">
                            Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                        </span>
                    </div>

                    @if($status === 'selesai')
                        <div class="flex items-center gap-2">
                            @if(!$order->review)
                                <a href="{{ route('pesanan.review.create', $order->id) }}" class="px-5 py-2.5 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer whitespace-nowrap">
                                    Beri Ulasan
                                </a>
                            @endif
                            <a href="{{ route('pesanan.show', $order->id) }}" class="px-5 py-2.5 bg-[#EAEFE2] hover:bg-[#DCECD8] text-[#2D5A27] font-bold text-xs rounded-xl shadow-xs border border-[#D2E6CE] transition-all cursor-pointer whitespace-nowrap">
                                Lihat Detail
                            </a>
                        </div>
                    @elseif($status === 'disetujui')
                        <div class="flex items-center gap-2">
                            <form action="{{ route('pesanan.selesai', $order->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-5 py-2.5 bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold text-xs rounded-xl shadow-xs transition-all cursor-pointer whitespace-nowrap">
                                    Selesai
                                </button>
                            </form>
                            <a href="{{ route('pesanan.show', $order->id) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs rounded-xl border border-gray-200 transition-all cursor-pointer whitespace-nowrap">
                                Detail Pesanan
                            </a>
                        </div>
                    @elseif($status === 'batal' || $status === 'dibatalkan' || $status === 'ditolak')
                        <a href="{{ route('pesanan.show', $order->id) }}" class="px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold text-xs rounded-xl border border-gray-200 transition-all cursor-pointer whitespace-nowrap">
                            Detail Pesanan
                        </a>
                    @else
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="confirmCancelOrder({{ $order->id }})" class="px-4 py-2.5 bg-red-50 hover:bg-red-100 text-red-700 font-bold text-xs rounded-xl border border-red-200 transition-all cursor-pointer whitespace-nowrap" style="background-color: #fef2f2 !important; color: #b91c1c !important;">
                                Batalkan
                            </button>
                            <a href="{{ route('pesanan.show', $order->id) }}" class="px-5 py-2.5 bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold text-xs rounded-xl shadow-sm transition-all cursor-pointer whitespace-nowrap">
                                Detail Pesanan
                            </a>
                        </div>
                    @endif
                </div>

            </div>
        @empty
            <div id="emptyOrdersNotice" class="text-center py-16 bg-white rounded-3xl border border-[#E5E5DC] p-8 space-y-4">
                <div class="w-16 h-16 bg-[#F8F9F3] text-gray-400 rounded-full flex items-center justify-center mx-auto text-3xl">
                    📦
                </div>
                <div class="space-y-1">
                    <h3 class="text-xl font-bold font-serif text-gray-900">Belum Ada Pesanan</h3>
                    <p class="text-xs text-gray-500 font-light">Anda belum memiliki riwayat pemesanan catering.</p>
                </div>
                <a href="/" class="inline-block px-6 py-3 bg-[#3B420C] text-white font-bold text-xs rounded-xl shadow-sm hover:bg-[#2C3109] transition-all">
                    Jelajahi Paket Catering
                </a>
            </div>
        @endforelse

        <!-- Filtered Empty Notice -->
        <div id="filteredEmptyNotice" class="hidden text-center py-16 bg-white rounded-3xl border border-[#E5E5DC] p-8 space-y-4">
            <div class="w-16 h-16 bg-[#F8F9F3] text-gray-400 rounded-full flex items-center justify-center mx-auto text-3xl">
                🔎
            </div>
            <div class="space-y-1">
                <h3 class="text-xl font-bold font-serif text-gray-900">Tidak Ada Pesanan Ditampilkan</h3>
                <p class="text-xs text-gray-500 font-light">Tidak ada pesanan dengan status terpilih.</p>
            </div>
        </div>
    </div>

    <!-- PAGINATION / LOAD MORE BUTTON -->
    @if(count($myOrders) > 5)
    <div class="flex justify-center pt-4">
        <button type="button" id="loadMoreBtn" onclick="loadMoreOrders()" class="px-6 py-3 bg-[#EAEFE2] hover:bg-[#DCECD8] text-gray-800 font-semibold text-xs rounded-full shadow-xs border border-[#D2E6CE] flex items-center gap-2 transition-all cursor-pointer">
            <span>Tampilkan Lebih Banyak</span>
            <span>∨</span>
        </button>
    </div>
    @endif

</main>
@endsection

@section('modals')
<!-- ORDER DETAIL MODAL -->
<div id="orderDetailViewModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full space-y-5 ambient-shadow border border-gray-100 max-h-[90vh] overflow-y-auto animate-fade-in">
        <div class="flex justify-between items-center pb-3 border-b border-gray-100">
            <div>
                <span id="modalOrderCode" class="text-xs font-mono font-bold text-gray-500"></span>
                <h3 class="text-xl font-bold font-serif text-gray-900">Detail Pesanan</h3>
            </div>
            <button onclick="closeOrderDetailModal()" class="text-gray-400 hover:text-gray-600 text-lg p-1">✕</button>
        </div>

        <div class="space-y-4 text-xs">
            <div class="bg-[#F8F9F3] p-4 rounded-2xl border border-gray-200 space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-500">Tanggal Acara:</span>
                    <span id="modalTglAcara" class="font-bold text-gray-900"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Jumlah Pax:</span>
                    <span id="modalJumlahPax" class="font-bold text-gray-900"></span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status:</span>
                    <span id="modalStatusBadge" class="font-bold"></span>
                </div>
            </div>

            <div class="space-y-2">
                <h4 class="font-bold text-gray-900 uppercase tracking-wider text-[10px]">Alamat Pengiriman</h4>
                <p id="modalAlamat" class="text-gray-600 leading-relaxed bg-gray-50 p-3 rounded-xl border border-gray-100"></p>
            </div>

            <div class="space-y-2">
                <h4 class="font-bold text-gray-900 uppercase tracking-wider text-[10px]">Rincian Biaya</h4>
                <div class="bg-[#F8F9F3] p-4 rounded-2xl border border-gray-200 space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Total Harga:</span>
                        <span id="modalTotalHarga" class="font-bold font-serif text-base text-[#2D5A27]"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-2 flex flex-col gap-2">
            <button type="button" id="modalCancelBtn" class="hidden w-full text-white font-bold py-3.5 rounded-xl transition-all text-xs cursor-pointer shadow-sm border border-red-700" style="background-color: #dc2626 !important; color: #ffffff !important;">
                Batalkan Pesanan Ini
            </button>
            <button type="button" onclick="closeOrderDetailModal()" class="w-full text-white font-bold py-3.5 rounded-xl transition-all text-xs cursor-pointer shadow-xs" style="background-color: #3B420C !important; color: #ffffff !important;">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- CANCELLATION CONFIRMATION MODAL -->
<div id="cancelConfirmModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-sm w-full text-center space-y-4 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="w-14 h-14 bg-red-50 text-red-600 rounded-full flex items-center justify-center mx-auto text-2xl font-bold" style="background-color: #fef2f2 !important; color: #dc2626 !important;">
            ⚠️
        </div>
        <div class="space-y-1.5">
            <h3 class="text-xl font-bold font-serif text-gray-900">Batalkan Pesanan?</h3>
            <p class="text-xs text-gray-600 font-light leading-relaxed">
                Apakah Anda yakin ingin membatalkan pesanan ini? Tindakan ini tidak dapat dibatalkan kembali.
            </p>
        </div>
        <div class="pt-2 flex flex-col gap-2.5">
            <button type="button" id="confirmCancelSubmitBtn" onclick="executeOrderCancellation()" class="w-full text-white font-bold py-3.5 px-4 rounded-xl transition-all text-xs cursor-pointer shadow-md border border-red-700" style="background-color: #dc2626 !important; color: #ffffff !important;">
                Ya, Batalkan Pesanan
            </button>
            <button type="button" onclick="closeCancelConfirmModal()" class="w-full text-gray-800 font-bold py-3.5 px-4 rounded-xl transition-all text-xs cursor-pointer border border-gray-300" style="background-color: #f3f4f6 !important; color: #1f2937 !important;">
                Kembali / Batal
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    let currentModalOrderId = null;
    let orderIdToCancel = null;

    function filterOrders(category, btn) {
        document.querySelectorAll('.order-tab').forEach(tab => {
            tab.classList.remove('active-tab', 'text-[#2D5A27]', 'border-[#2D5A27]', 'font-bold');
            tab.classList.add('text-gray-500', 'border-transparent');
        });

        btn.classList.add('active-tab', 'text-[#2D5A27]', 'border-[#2D5A27]', 'font-bold');
        btn.classList.remove('text-gray-500', 'border-transparent');

        const cards = document.querySelectorAll('.order-card-item');
        let visibleCount = 0;

        cards.forEach(card => {
            const cardCat = card.getAttribute('data-category');
            if (category === 'semua' || cardCat === category) {
                card.classList.remove('hidden');
                visibleCount++;
            } else {
                card.classList.add('hidden');
            }
        });

        const filteredEmpty = document.getElementById('filteredEmptyNotice');
        if (visibleCount === 0 && cards.length > 0) {
            filteredEmpty.classList.remove('hidden');
        } else if (filteredEmpty) {
            filteredEmpty.classList.add('hidden');
        }
    }

    function showOrderDetailModal(order) {
        currentModalOrderId = order.id;
        document.getElementById('modalOrderCode').innerText = '#NSL-' + String(order.id).padStart(8, '0');
        document.getElementById('modalTglAcara').innerText = order.tgl_acara || '-';
        document.getElementById('modalJumlahPax').innerText = (order.jumlah_pax || 0) + ' Pax';
        document.getElementById('modalAlamat').innerText = order.alamat_pengiriman || '-';
        document.getElementById('modalTotalHarga').innerText = 'Rp ' + Number(order.total_harga || 0).toLocaleString('id-ID');

        const statusStr = strtolower(order.status_pesanan || '');
        const badge = document.getElementById('modalStatusBadge');
        badge.innerText = (order.status_pesanan || 'Menunggu').toUpperCase();

        const modalCancelBtn = document.getElementById('modalCancelBtn');
        if (modalCancelBtn) {
            if (['selesai', 'batal', 'dibatalkan', 'ditolak'].includes(statusStr)) {
                modalCancelBtn.classList.add('hidden');
            } else {
                modalCancelBtn.classList.remove('hidden');
                modalCancelBtn.onclick = function() {
                    confirmCancelOrder(order.id);
                };
            }
        }

        document.getElementById('orderDetailViewModal').classList.remove('hidden');
    }

    function closeOrderDetailModal() {
        document.getElementById('orderDetailViewModal').classList.add('hidden');
    }

    function confirmCancelOrder(orderId) {
        orderIdToCancel = orderId;
        closeOrderDetailModal();
        document.getElementById('cancelConfirmModal').classList.remove('hidden');
    }

    function closeCancelConfirmModal() {
        orderIdToCancel = null;
        document.getElementById('cancelConfirmModal').classList.add('hidden');
    }

    function executeOrderCancellation() {
        if (!orderIdToCancel) return;

        const btn = document.getElementById('confirmCancelSubmitBtn');
        if (btn) btn.disabled = true;

        fetch(`/pesanan/${orderIdToCancel}/batalkan`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Gagal membatalkan pesanan.');
                if (btn) btn.disabled = false;
            }
        })
        .catch(() => {
            alert('Terjadi kesalahan koneksi.');
            if (btn) btn.disabled = false;
        });
    }

    function strtolower(str) {
        return (str || '').toLowerCase();
    }
</script>
@endsection

