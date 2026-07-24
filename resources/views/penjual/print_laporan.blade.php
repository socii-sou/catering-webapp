<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulir Rekapitulasi Laporan Penjualan - RASACI Catering</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1F2937;
            background-color: #F8F9FA;
        }
        .font-serif {
            font-family: 'Playfair Display', serif;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #FFFFFF !important;
                padding: 0 !important;
                margin: 0 !important;
            }
            .page-container {
                box-shadow: none !important;
                border: none !important;
                padding: 0 !important;
                margin: 0 auto !important;
                width: 100% !important;
                max-width: 100% !important;
            }
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body class="py-8 px-4 sm:px-6">

    <!-- FLOATING TOP BAR FOR ACTIONS (Non-printable) -->
    <div class="no-print max-w-4xl mx-auto mb-6 flex items-center justify-between bg-white p-4 rounded-2xl shadow-md border border-gray-200">
        <a href="{{ route('penjual.dashboard') }}" class="flex items-center gap-2 text-xs font-bold text-gray-700 hover:text-[#2D5A27] transition-colors">
            <span>←</span>
            <span>Kembali ke Dashboard</span>
        </a>
        <div class="flex items-center gap-3">
            <button onclick="window.print()" class="bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-2 px-5 rounded-xl text-xs flex items-center gap-2 transition-all cursor-pointer shadow-sm">
                <span>🖨️</span>
                <span>Cetak / Simpan PDF</span>
            </button>
        </div>
    </div>

    <!-- MAIN FORMULIR CONTAINER (A4 Styled Box) -->
    <div class="page-container max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-3xl shadow-xl border border-stone-200 space-y-8">
        
        <!-- HEADER KOP SURAT LAPORAN -->
        <div class="border-b-2 border-[#2D5A27] pb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="space-y-1">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-[#2D5A27] text-white font-bold flex items-center justify-center font-serif text-lg">
                        R
                    </div>
                    <span class="text-2xl font-extrabold font-serif text-gray-900 tracking-tight">RASACI CATERING</span>
                </div>
                <p class="text-xs text-gray-500 font-medium">Layanan Catering Modern & Manajemen Dapur Nusantara</p>
                <p class="text-[11px] text-gray-400 font-light">Jl. Raya Catering No. 88, Jakarta Selatan • Telp/WA: +62 813-8902-5947</p>
            </div>
            
            <div class="text-left sm:text-right border-l-2 sm:border-l-0 border-[#2D5A27] pl-3 sm:pl-0 space-y-0.5">
                <span class="px-3 py-1 rounded-full bg-[#EBF5E8] text-[#2D5A27] text-[10px] font-extrabold uppercase tracking-widest inline-block mb-1">DOKUMEN RESMI</span>
                <h2 class="text-xs font-bold text-gray-800 uppercase tracking-wider">Formulir Rekapitulasi Laporan</h2>
                <p class="text-[11px] text-gray-500 font-mono">No. Dok: RPT-{{ date('Ymd') }}-{{ rand(100,999) }}</p>
                <p class="text-[11px] text-gray-500">Tanggal Cetak: <strong class="text-gray-900 font-semibold">{{ now()->translatedFormat('d F Y, H:i') }} WIB</strong></p>
            </div>
        </div>

        <!-- FORM TITLE & METADATA -->
        <div class="text-center space-y-2 py-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold font-serif text-gray-900 tracking-tight uppercase">
                FORMULIR REKAPITULASI LAPORAN PENJUALAN
            </h1>
            <p class="text-xs text-gray-600 font-medium">
                Rekapitulasi Transaksi & Omzet Keseluruhan Dapur RASACI Catering
            </p>
        </div>

        <!-- SUMMARY METRIC BOXES -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 bg-[#F8F9F3] p-5 rounded-2xl border border-[#E5E5DC]">
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">TOTAL TRANSAKSI</span>
                <div class="text-xl font-bold font-serif text-gray-900">{{ number_format($totalOrdersCount, 0, ',', '.') }} Pesanan</div>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">TOTAL OMZET PENJUALAN</span>
                <div class="text-xl font-extrabold font-serif text-[#2D5A27]">Rp {{ number_format($totalSalesSum, 0, ',', '.') }}</div>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">RATA-RATA TRANSAKSI</span>
                <div class="text-base font-bold font-serif text-gray-800">Rp {{ number_format($avgOrderValue, 0, ',', '.') }}</div>
            </div>
            <div class="space-y-1">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block">PENDING VALIDASI</span>
                <div class="text-xl font-bold font-serif text-amber-600">{{ $pendingValidationCount }} Pesanan</div>
            </div>
        </div>

        <!-- RINCIAN TABEL PENJUALAN -->
        <div class="space-y-3">
            <div class="flex justify-between items-center">
                <h3 class="text-sm font-bold font-serif text-gray-900 uppercase tracking-wider">
                    Rincian Transaksi Penjualan
                </h3>
                <span class="text-[11px] text-gray-500 font-medium">Total: {{ $orders->count() }} Transaksi Terekam</span>
            </div>

            <div class="overflow-x-auto rounded-xl border border-gray-200">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-[#2D5A27] text-white font-bold uppercase text-[10px] tracking-wider">
                            <th class="py-3 px-3.5 text-center w-10">NO</th>
                            <th class="py-3 px-3.5">ID PESANAN</th>
                            <th class="py-3 px-3.5">PAKET & GUBUKAN</th>
                            <th class="py-3 px-3.5">STATUS</th>
                            <th class="py-3 px-3.5 text-right">TOTAL HARGA</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 font-medium bg-white">
                        @forelse($orders as $index => $order)
                            @php
                                $paketItem = $order->pesananPaket->first()?->paket;
                                $statusRaw = strtolower($order->status_pesanan);
                                $prodStatus = strtolower($order->status_produksi);
                                $shipStatus = $order->pengiriman ? strtolower($order->pengiriman->status_pengiriman) : 'belum_dikirim';

                                $statusPill = 'Menunggu Validasi';
                                if ($statusRaw === 'selesai' || $shipStatus === 'sampai') {
                                    $statusPill = 'Selesai';
                                } elseif ($shipStatus === 'dikirim') {
                                    $statusPill = 'Dikirim';
                                } elseif ($prodStatus === 'diproses') {
                                    $statusPill = 'Di Masak';
                                } elseif (in_array($statusRaw, ['disetujui', 'dikonfirmasi'])) {
                                    $statusPill = 'Dikonfirmasi';
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-3 px-3.5 text-center font-bold text-gray-500">{{ $index + 1 }}</td>
                                <td class="py-3 px-3.5 font-mono font-bold text-gray-900">#ORD-{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-3 px-3.5 text-gray-800 font-medium">
                                    {{ $paketItem->nm_paket ?? 'Paket Catering' }} ({{ $order->jumlah_pax }} Pax)
                                    @if($order->gubukan)
                                        <br><span class="text-[10px] text-amber-700 font-bold">+ {{ $order->gubukan->nama_gubukan }} ({{ $order->jumlah_pax_gubukan ?? $order->jumlah_pax }} Pax)</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3.5">
                                    <span class="px-2.5 py-0.5 rounded-full text-[9px] font-extrabold uppercase border {{ $statusRaw === 'selesai' ? 'bg-green-100 text-green-800 border-green-300' : ($statusRaw === 'menunggu_validasi' ? 'bg-amber-100 text-amber-800 border-amber-300' : 'bg-blue-100 text-blue-800 border-blue-300') }}">
                                        {{ $statusPill }}
                                    </span>
                                </td>
                                <td class="py-3 px-3.5 text-right font-serif font-bold text-gray-900">
                                    Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-400 font-medium">Belum ada transaksi penjualan terekam.</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr class="bg-[#F8F9F3] text-gray-900 font-bold text-xs border-t-2 border-gray-300">
                            <td colspan="4" class="py-3 px-3.5 text-right font-serif uppercase tracking-wider">TOTAL OMZET KESELURUHAN</td>
                            <td class="py-3 px-3.5 text-right font-serif text-sm font-extrabold text-[#2D5A27]">
                                Rp {{ number_format($totalSalesSum, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- FORMULIR SIGNATURE & APPROVAL SECTION -->
        <div class="pt-8 border-t border-gray-200 grid grid-cols-2 gap-8 text-xs">
            <div class="space-y-1 text-gray-500">
                <span class="font-bold text-gray-800 uppercase block tracking-wider text-[10px]">CATATAN DOKUMEN:</span>
                <p class="text-[11px] leading-relaxed font-light">
                    • Formulir ini dicetak secara otomatis dari sistem manajemen RASACI Catering.<br>
                    • Seluruh data yang tertera pada laporan ini bersifat sah dan terlacak secara sistem real-time.
                </p>
            </div>

            <div class="text-right space-y-12">
                <div>
                    <span class="text-gray-500 text-[11px] block">Jakarta Selatan, {{ now()->translatedFormat('d F Y') }}</span>
                    <span class="font-bold text-gray-900 uppercase block tracking-wider mt-0.5 text-[11px]">Penanggung Jawab / Kitchen Lead</span>
                </div>

                <div class="space-y-1">
                    <span class="font-bold text-gray-900 underline block text-sm font-serif">PENJUAL (Kitchen Manager)</span>
                    <span class="text-[10px] text-gray-400 block font-mono">RASACI CATERING OFFICIAL</span>
                </div>
            </div>
        </div>

    </div>

    <!-- AUTO PRINT TRIGGER SCRIPTS -->
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            // Auto trigger browser print after page renders
            setTimeout(() => {
                window.print();
            }, 600);
        });
    </script>
</body>
</html>
