@extends('layouts.app')

@section('title', 'Konfirmasi Pesanan - RASACI Catering')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-8">

    <!-- STEPPER HEADER -->
    <div class="flex items-center justify-center max-w-xl mx-auto py-2">
        <div class="flex items-center space-x-8 w-full justify-between">
            <!-- Step 1 (Completed) -->
            <a href="{{ route('paket.show', $paket->id) }}" class="flex items-center gap-2.5 text-xs font-medium text-[#2D5A27] hover:underline">
                <div class="w-7 h-7 rounded-full bg-[#EBF5E8] border border-[#2D5A27] text-[#2D5A27] flex items-center justify-center text-xs font-bold">
                    ✓
                </div>
                <span class="hidden sm:inline font-bold">Detail</span>
            </a>

            <div class="flex-1 h-0.5 bg-[#2D5A27]"></div>

            <!-- Step 2 (Active) -->
            <div class="flex items-center gap-2.5 text-xs font-bold text-gray-900">
                <div class="w-7 h-7 rounded-full bg-[#3B420C] text-white flex items-center justify-center text-xs font-bold shadow-xs">
                    2
                </div>
                <span>Pembayaran</span>
            </div>

            <div class="flex-1 h-0.5 bg-gray-200"></div>

            <!-- Step 3 (Pending) -->
            <div class="flex items-center gap-2.5 text-xs font-medium text-gray-400">
                <div class="w-7 h-7 rounded-full border border-gray-200 bg-white flex items-center justify-center text-xs text-gray-400 font-bold">
                    3
                </div>
                <span class="hidden sm:inline">Selesai</span>
            </div>
        </div>
    </div>

    @php
        $paketSubtotal = $paket->harga_paket * $jumlahPax;
        $gubukanSubtotal = $selectedGubukan ? ($selectedGubukan->harga_gubukan * $jumlahPax) : 0;
        $deliveryFee = 150000;
        $grandTotal = $paketSubtotal + $gubukanSubtotal + $deliveryFee;
        $dpTotal = $grandTotal * 0.5;

        $heroImage = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300';
        if (str_contains(strtolower($paket->nm_paket), 'prasmanan')) {
            $heroImage = 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=300';
        } elseif (str_contains(strtolower($paket->nm_paket), 'tumpeng')) {
            $heroImage = 'https://images.unsplash.com/photo-1626777552726-4a6b54c97e46?auto=format&fit=crop&q=80&w=300';
        }

        $backUrl = route('checkout') . '?paket_id=' . $paket->id
            . '&jumlah_pax=' . $jumlahPax
            . '&tgl_acara=' . urlencode($tglAcara)
            . '&lauk_ids=' . implode(',', $laukIds)
            . ($selectedGubukan ? '&gubukan_id=' . $selectedGubukan->id : '')
            . '&alamat_pengiriman=' . urlencode($alamatPengiriman)
            . '&catatan=' . urlencode($catatan);
    @endphp

    <!-- HEADER TITLE & BACK LINK -->
    <div class="space-y-1">
        <a href="{{ $backUrl }}" class="inline-flex items-center gap-1.5 text-xs text-red-700 hover:text-red-900 font-medium transition-colors">
            <span>←</span>
            <span>Kembali ke Detail Pengiriman</span>
        </a>
        <h1 class="text-3xl sm:text-4xl font-extrabold font-serif text-gray-900 tracking-tight">
            Konfirmasi Pesanan
        </h1>
    </div>

    <!-- MAIN GRID CONTAINER -->
    <form id="pembayaranForm" onsubmit="submitKonfirmasiPesanan(event)" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        @csrf

        <!-- LEFT COLUMN: RINGKASAN PESANAN (Span 5) -->
        <div class="lg:col-span-5 lg:sticky lg:top-24 space-y-6">
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-sm space-y-5">
                <h3 class="text-xl font-bold font-serif text-gray-900">Ringkasan Pesanan</h3>

                <!-- Product Preview Card -->
                <div class="flex items-center gap-4 pb-4 border-b border-gray-100">
                    <img src="{{ $heroImage }}" alt="{{ $paket->nm_paket }}" class="w-16 h-16 rounded-2xl object-cover shadow-xs border border-gray-100">
                    <div class="space-y-0.5 min-w-0 flex-1">
                        <h4 class="text-sm font-bold text-[#8A3017] truncate font-serif">{{ $paket->nm_paket }}</h4>
                        <p class="text-[11px] text-gray-500">
                            Jadwal: {{ \Carbon\Carbon::parse($tglAcara)->translatedFormat('d M Y') }} • 12:00 WIB
                        </p>
                        <p class="text-xs font-semibold text-gray-900">
                            Rp {{ number_format($paket->harga_paket, 0, ',', '.') }} <span class="text-[10px] text-gray-400 font-normal">/ pax</span>
                        </p>
                    </div>
                </div>

                <!-- Detailed Breakdown -->
                <div class="space-y-2.5 text-xs">
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Package Price ({{ $jumlahPax }} Pax)</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($paketSubtotal, 0, ',', '.') }}</span>
                    </div>

                    @if($selectedGubukan)
                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Gubukan ({{ $selectedGubukan->nama_gubukan }})</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($gubukanSubtotal, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Delivery Fee</span>
                        <span class="font-medium text-gray-900">Rp {{ number_format($deliveryFee, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600 font-light">
                        <span>Tax & Service (0%)</span>
                        <span class="text-[#2D5A27] font-semibold">Free</span>
                    </div>
                </div>

                <!-- Total & DP Box -->
                <div class="pt-3 border-t border-gray-100 space-y-3">
                    <div class="flex justify-between items-baseline">
                        <span class="text-base font-bold text-gray-900 font-serif">Grand Total</span>
                        <span class="text-xl font-extrabold text-[#2D5A27] font-serif">Rp {{ number_format($grandTotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="bg-[#FDF0ED] border border-[#F7D6CD] rounded-2xl p-3.5 flex justify-between items-center">
                        <span class="text-xs font-bold text-[#8A3017]">Wajib Bayar (DP 50%)</span>
                        <span class="text-base font-extrabold text-[#8A3017] font-serif">Rp {{ number_format($dpTotal, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- WhatsApp Help Box -->
            <div class="p-4 bg-[#EBF5E8] rounded-2xl border border-[#D2E6CE] flex items-center gap-3 text-xs text-[#2D5A27]">
                <span class="text-lg">💬</span>
                <div>
                    <p class="font-light">Butuh bantuan transaksi?</p>
                    <a href="https://wa.me/6281389025947?text=Halo%20RASACI%20Kitchen,%20saya%20butuh%20bantuan%20mengenai%20pembayaran" target="_blank" class="font-bold underline hover:text-[#1b3d17]">
                        Hubungi WhatsApp Kitchen
                    </a>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                <div class="flex items-center gap-3.5 bg-white border border-[#E5E5DC] rounded-2xl p-4 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-lg shrink-0">
                        🛡️
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900">Aman & Terpercaya</h4>
                        <p class="text-[11px] text-gray-500 font-light">Enkripsi data 256-bit</p>
                    </div>
                </div>

                <div class="flex items-center gap-3.5 bg-white border border-[#E5E5DC] rounded-2xl p-4 shadow-xs">
                    <div class="w-10 h-10 rounded-full bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-lg shrink-0">
                        🎧
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-gray-900">Layanan Pelanggan</h4>
                        <p class="text-[11px] text-gray-500 font-light">Siap membantu 24/7</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: CHOOSE PAYMENT METHOD & SUBMIT (Span 7) -->
        <div class="lg:col-span-7 space-y-6">

            <!-- Card 0: Choose Payment Method -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-base">
                        💳
                    </div>
                    <h2 class="text-xl font-bold font-serif text-gray-900">Pilih Metode Pembayaran</h2>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Option 1: Midtrans QRIS & Instant VA -->
                    <div onclick="switchPaymentMethod('midtrans')" id="methodCardMidtrans" class="payment-method-card bg-[#F4F7EE] border-2 border-[#2D5A27] rounded-2xl p-4 cursor-pointer flex flex-col justify-between transition-all">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-[#2D5A27] flex items-center gap-1.5">
                                <span>📱</span> QRIS / Midtrans (Instan)
                            </span>
                            <input type="radio" id="pay_method_midtrans" name="metode_pembayaran_choice" value="midtrans" checked class="accent-[#2D5A27] pointer-events-none">
                        </div>
                        <p class="text-[11px] text-gray-600 font-light leading-relaxed">
                            Scan QRIS via GoPay, OVO, ShopeePay, Dana, BCA Mobile & VA Bank. Verifikasi otomatis.
                        </p>
                    </div>

                    <!-- Option 2: Transfer Bank Manual -->
                    <div onclick="switchPaymentMethod('manual')" id="methodCardManual" class="payment-method-card bg-white border border-gray-200 rounded-2xl p-4 cursor-pointer flex flex-col justify-between hover:border-[#2D5A27] transition-all">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs font-bold text-gray-800 flex items-center gap-1.5">
                                <span>🏦</span> Transfer Bank Manual
                            </span>
                            <input type="radio" id="pay_method_manual" name="metode_pembayaran_choice" value="manual" class="accent-[#2D5A27] pointer-events-none">
                        </div>
                        <p class="text-[11px] text-gray-600 font-light leading-relaxed">
                            Transfer ke rekening BCA / BNI & unggah bukti transfer manual.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Card 1: Midtrans QRIS Info Banner -->
            <div id="midtransInfoCard" class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-base">
                        ⚡
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900 font-serif">Pembayaran QRIS & Snap Midtrans</h3>
                        <p class="text-xs text-gray-500">Generate QRIS instan dan bayar secara otomatis</p>
                    </div>
                </div>

                <div class="p-4 bg-[#EBF5E8]/60 rounded-2xl border border-[#D2E6CE] text-xs text-[#2D5A27] space-y-1.5">
                    <p class="font-bold flex items-center gap-1">
                        <span>✅</span> Verifikasi Langsung & Tanpa Upload Bukti
                    </p>
                    <p class="text-[11px] text-gray-600 font-light leading-relaxed">
                        Saat tombol "KONFIRMASI PESANAN" diklik, popup QRIS akan otomatis muncul. Posisikan kamera m-Banking atau aplikasi E-Wallet Anda untuk scan.
                    </p>
                </div>
            </div>

            <!-- Card 2: Instruksi Transfer Bank Manual (Hidden by Default) -->
            <div id="manualBankCard" class="hidden bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-xl bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center text-base">
                        🏦
                    </div>
                    <h2 class="text-xl font-bold font-serif text-gray-900">Instruksi Transfer Bank</h2>
                </div>

                <p class="text-xs text-gray-600 leading-relaxed">
                    Silakan lakukan transfer ke salah satu rekening resmi RASACI CATERING di bawah ini untuk mengkonfirmasi pesanan Anda.
                </p>

                <!-- Bank Cards Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                    <!-- Bank BCA -->
                    <div class="bg-[#F8F9F3] border border-[#E5E8DD] rounded-2xl p-4 space-y-2 relative group hover:border-[#2D5A27] transition-all">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">BANK CENTRAL ASIA (BCA)</span>
                            <button type="button" onclick="copyToClipboard('8832109200', this)" class="text-gray-400 hover:text-[#2D5A27] p-1 transition-colors cursor-pointer" title="Salin Nomor Rekening">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-lg font-extrabold text-gray-900 tracking-wider font-mono">
                            8832 1092 00
                        </div>
                        <div class="text-xs text-gray-500 font-medium">
                            a.n. RASACI CATERING
                        </div>
                    </div>

                    <!-- Bank BNI -->
                    <div class="bg-[#F8F9F3] border border-[#E5E8DD] rounded-2xl p-4 space-y-2 relative group hover:border-[#2D5A27] transition-all">
                        <div class="flex justify-between items-center">
                            <span class="text-[10px] font-bold text-gray-500 uppercase tracking-wider">BANK NEGARA INDONESIA (BNI)</span>
                            <button type="button" onclick="copyToClipboard('120001229982', this)" class="text-gray-400 hover:text-[#2D5A27] p-1 transition-colors cursor-pointer" title="Salin Nomor Rekening">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="text-lg font-extrabold text-gray-900 tracking-wider font-mono">
                            1200 0122 9982
                        </div>
                        <div class="text-xs text-gray-500 font-medium">
                            a.n. RASACI CATERING
                        </div>
                    </div>
                </div>

                <!-- Operational Notice -->
                <div class="p-4 bg-[#EBF5E8] rounded-2xl border border-[#D2E6CE] flex items-start gap-3 text-xs text-[#2D5A27]">
                    <span class="text-base leading-none">ℹ️</span>
                    <p class="leading-relaxed">
                        Transfer sebelum jam 16:00 WIB agar pesanan dapat segera diproses untuk jadwal pengiriman besok.
                    </p>
                </div>
            </div>

            <!-- Card 3: Pembayaran DP (50%) & File Upload (Hidden by Default for Midtrans) -->
            <div id="manualProofCard" class="hidden bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="space-y-1">
                        <h2 class="text-xl font-bold font-serif text-gray-900">Pembayaran DP (50%)</h2>
                        <p class="text-xs text-gray-500">Segera unggah bukti transfer untuk verifikasi manual.</p>
                    </div>

                    <!-- Highlight Box TOTAL DP DIBAYAR -->
                    <div class="bg-[#FDF0ED] border border-[#F7D6CD] rounded-2xl px-5 py-3 text-right">
                        <div class="text-[10px] font-bold text-[#A84325] uppercase tracking-wider">TOTAL DP DIBAYAR</div>
                        <div class="text-2xl font-black text-[#8A3017] font-serif">Rp {{ number_format($dpTotal, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Proof of Payment Upload Box -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-gray-800">Bukti Pembayaran DP</label>
                    <div id="dropZone" onclick="triggerFileSelect()" class="border-2 border-dashed border-gray-300 hover:border-[#2D5A27] rounded-3xl p-8 text-center transition-all bg-[#FAFBF7] cursor-pointer group space-y-3">
                        <div class="w-12 h-12 rounded-full bg-[#EBF5E8] text-[#2D5A27] flex items-center justify-center mx-auto text-xl shadow-xs group-hover:scale-110 transition-transform">
                            ☁️
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-gray-800">
                                Klik untuk unggah <span class="font-normal text-gray-500">atau seret file ke sini</span>
                            </p>
                            <p class="text-[11px] text-gray-400">
                                Maksimal 5MB (JPG, PNG, PDF)
                            </p>
                        </div>
                        <input type="file" id="bukti_bayar_input" name="bukti_bayar" accept="image/*,.pdf" class="hidden" onchange="handleFileSelect(event)">
                    </div>

                    <!-- File Preview Area -->
                    <div id="filePreview" class="hidden bg-[#F4F7EE] border border-[#D2E6CE] rounded-2xl p-4 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📄</span>
                            <div>
                                <p id="fileName" class="text-xs font-bold text-gray-900 truncate max-w-xs"></p>
                                <p id="fileSize" class="text-[10px] text-gray-500"></p>
                            </div>
                        </div>
                        <button type="button" onclick="removeFile()" class="text-gray-400 hover:text-red-600 text-sm p-1 transition-colors">
                            ✕
                        </button>
                    </div>
                </div>
            </div>

            <!-- Submit Action Card -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-[#E5E5DC] shadow-xs space-y-4">
                <!-- Error Alert -->
                <div id="pembayaranErrorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-3.5 rounded-xl">
                    <p id="pembayaranErrorText" class="text-xs text-red-700 font-medium"></p>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="pembayaranSubmitBtn" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-4 rounded-2xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer text-xs uppercase tracking-wider">
                    <span>KONFIRMASI PESANAN</span>
                    <div id="pembayaranSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                </button>

                <p class="text-[10px] text-gray-400 text-center font-light leading-relaxed">
                    Dengan mengklik Konfirmasi Pesanan, Anda menyetujui <a href="#" class="underline hover:text-gray-600">Syarat & Ketentuan</a> yang berlaku.
                </p>
            </div>

        </div>

    </form>

</main>
@endsection

@section('modals')
<!-- SUCCESS CONFIRMATION MODAL -->
<div id="pembayaranSuccessModal" class="fixed inset-0 bg-black/60 backdrop-blur-xs z-50 flex items-center justify-center p-4 hidden">
    <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full text-center space-y-5 ambient-shadow border border-gray-100 animate-fade-in">
        <div class="w-16 h-16 bg-[#EBF5E8] text-[#2D5A27] rounded-full flex items-center justify-center mx-auto text-3xl font-bold shadow-xs">
            ✓
        </div>
        <div class="space-y-2">
            <h3 class="text-2xl font-bold font-serif text-gray-900">Pesanan Berhasil Dibuat!</h3>
            <p class="text-xs text-gray-600 font-light leading-relaxed">
                Terima kasih telah melakukan konfirmasi pembayaran. Tim kami akan segera memverifikasi bukti transfer Anda.
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
@section('scripts')
<script src="{{ config('services.midtrans.is_production') ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script>
    let selectedPaymentMethod = 'midtrans';

    function switchPaymentMethod(method) {
        selectedPaymentMethod = method;

        const cardMidtrans = document.getElementById('methodCardMidtrans');
        const cardManual = document.getElementById('methodCardManual');
        const radioMidtrans = document.getElementById('pay_method_midtrans');
        const radioManual = document.getElementById('pay_method_manual');

        const midtransInfo = document.getElementById('midtransInfoCard');
        const manualBank = document.getElementById('manualBankCard');
        const manualProof = document.getElementById('manualProofCard');

        if (method === 'midtrans') {
            if (radioMidtrans) radioMidtrans.checked = true;
            if (radioManual) radioManual.checked = false;

            if (cardMidtrans) {
                cardMidtrans.className = "payment-method-card bg-[#F4F7EE] border-2 border-[#2D5A27] rounded-2xl p-4 cursor-pointer flex flex-col justify-between transition-all";
            }
            if (cardManual) {
                cardManual.className = "payment-method-card bg-white border border-gray-200 rounded-2xl p-4 cursor-pointer flex flex-col justify-between hover:border-[#2D5A27] transition-all";
            }

            if (midtransInfo) midtransInfo.classList.remove('hidden');
            if (manualBank) manualBank.classList.add('hidden');
            if (manualProof) manualProof.classList.add('hidden');
        } else {
            if (radioMidtrans) radioMidtrans.checked = false;
            if (radioManual) radioManual.checked = true;

            if (cardMidtrans) {
                cardMidtrans.className = "payment-method-card bg-white border border-gray-200 rounded-2xl p-4 cursor-pointer flex flex-col justify-between hover:border-[#2D5A27] transition-all";
            }
            if (cardManual) {
                cardManual.className = "payment-method-card bg-[#F4F7EE] border-2 border-[#2D5A27] rounded-2xl p-4 cursor-pointer flex flex-col justify-between transition-all";
            }

            if (midtransInfo) midtransInfo.classList.add('hidden');
            if (manualBank) manualBank.classList.remove('hidden');
            if (manualProof) manualProof.classList.remove('hidden');
        }
    }

    function copyToClipboard(text, btn) {
        navigator.clipboard.writeText(text).then(() => {
            const originalHTML = btn.innerHTML;
            btn.innerHTML = `<span class="text-[10px] text-green-700 font-bold">Tersalin!</span>`;
            setTimeout(() => {
                btn.innerHTML = originalHTML;
            }, 2000);
        }).catch(() => {
            alert('Gagal menyalin nomor rekening: ' + text);
        });
    }

    function triggerFileSelect() {
        document.getElementById('bukti_bayar_input').click();
    }

    function handleFileSelect(event) {
        const file = event.target.files[0];
        if (!file) return;

        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal adalah 5MB.');
            event.target.value = '';
            return;
        }

        document.getElementById('fileName').innerText = file.name;
        document.getElementById('fileSize').innerText = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
        document.getElementById('filePreview').classList.remove('hidden');
        document.getElementById('dropZone').classList.add('hidden');
    }

    function removeFile() {
        document.getElementById('bukti_bayar_input').value = '';
        document.getElementById('filePreview').classList.add('hidden');
        document.getElementById('dropZone').classList.remove('hidden');
    }

    // Drag and drop handlers
    const dropZone = document.getElementById('dropZone');
    if (dropZone) {
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
        });

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.add('border-[#2D5A27]', 'bg-[#EBF5E8]/30'), false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.classList.remove('border-[#2D5A27]', 'bg-[#EBF5E8]/30'), false);
        });

        dropZone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            const files = dt.files;
            if (files.length > 0) {
                document.getElementById('bukti_bayar_input').files = files;
                handleFileSelect({ target: { files: files } });
            }
        });
    }

    function openMyOrdersDrawer() {
        const modal = document.getElementById('pembayaranSuccessModal');
        if (modal) modal.classList.add('hidden');
        if (typeof toggleMyOrders === 'function') {
            toggleMyOrders();
        } else {
            window.location.href = '/pesanan';
        }
    }

    function submitKonfirmasiPesanan(event) {
        event.preventDefault();

        const submitBtn = document.getElementById('pembayaranSubmitBtn');
        const spinner = document.getElementById('pembayaranSpinner');
        const errBanner = document.getElementById('pembayaranErrorBanner');
        const errText = document.getElementById('pembayaranErrorText');

        if (selectedPaymentMethod === 'manual') {
            const fileInput = document.getElementById('bukti_bayar_input');
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                if (errBanner && errText) {
                    errText.innerText = 'Mohon unggah / lengkapi bukti pembayaran terlebih dahulu sebelum mengonfirmasi pesanan.';
                    errBanner.classList.remove('hidden');
                }
                return;
            }
        }

        if (submitBtn) submitBtn.disabled = true;
        if (spinner) spinner.classList.remove('hidden');
        if (errBanner) errBanner.classList.add('hidden');

        const formData = new FormData();
        formData.append('nama_acara', 'Acara Pelanggan');
        formData.append('alamat_pengiriman', @json($alamatPengiriman));
        formData.append('catatan', @json($catatan));
        if (@json($selectedGubukan ? $selectedGubukan->id : null)) {
            formData.append('gubukan_id', @json($selectedGubukan ? $selectedGubukan->id : null));
        }
        formData.append('tgl_acara', @json($tglAcara));
        formData.append('jumlah_pax', Number(@json($jumlahPax)));
        formData.append('metode_pembayaran_choice', selectedPaymentMethod);

        formData.append('items[0][paket_id]', @json($paket->id));
        formData.append('items[0][jml_paket]', Number(@json($jumlahPax)));
        const laukIds = @json($laukIds);
        laukIds.forEach((id, index) => {
            formData.append(`items[0][lauk_ids][${index}]`, id);
        });

        if (selectedPaymentMethod === 'manual') {
            const fileInput = document.getElementById('bukti_bayar_input');
            if (fileInput && fileInput.files && fileInput.files[0]) {
                formData.append('bukti_bayar', fileInput.files[0]);
            }
        }

        fetch('{{ route("web.pesanan.store") }}', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw new Error(data.message || 'Terjadi kesalahan sistem.');
                }
                return data;
            });
        })
        .then(data => {
            const pesananId = data.pesanan.id;

            if (selectedPaymentMethod === 'midtrans') {
                fetch(`/pesanan/${pesananId}/bayar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ jenis_pembayaran: 'dp' })
                })
                .then(res => res.json())
                .then(snapData => {
                    if (submitBtn) submitBtn.disabled = false;
                    if (spinner) spinner.classList.add('hidden');

                    if (snapData.snap_token && typeof window.snap !== 'undefined') {
                        window.snap.pay(snapData.snap_token, {
                            onSuccess: function(result) {
                                const successModal = document.getElementById('pembayaranSuccessModal');
                                if (successModal) successModal.classList.remove('hidden');
                            },
                            onPending: function(result) {
                                const successModal = document.getElementById('pembayaranSuccessModal');
                                if (successModal) successModal.classList.remove('hidden');
                            },
                            onError: function(result) {
                                if (errBanner && errText) {
                                    errText.innerText = 'Pembayaran gagal. Silakan coba lagi.';
                                    errBanner.classList.remove('hidden');
                                }
                            },
                            onClose: function() {
                                const successModal = document.getElementById('pembayaranSuccessModal');
                                if (successModal) successModal.classList.remove('hidden');
                            }
                        });
                    } else {
                        const successModal = document.getElementById('pembayaranSuccessModal');
                        if (successModal) successModal.classList.remove('hidden');
                    }
                })
                .catch(err => {
                    if (submitBtn) submitBtn.disabled = false;
                    if (spinner) spinner.classList.add('hidden');
                    const successModal = document.getElementById('pembayaranSuccessModal');
                    if (successModal) successModal.classList.remove('hidden');
                });
            } else {
                if (submitBtn) submitBtn.disabled = false;
                if (spinner) spinner.classList.add('hidden');
                const successModal = document.getElementById('pembayaranSuccessModal');
                if (successModal) successModal.classList.remove('hidden');
            }
        })
        .catch(error => {
            if (submitBtn) submitBtn.disabled = false;
            if (spinner) spinner.classList.add('hidden');
            if (errBanner && errText) {
                errText.innerText = error.message;
                errBanner.classList.remove('hidden');
            }
        });
    }
</script>
@endsection
