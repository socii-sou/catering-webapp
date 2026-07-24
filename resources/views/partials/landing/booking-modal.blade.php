<!-- BOOKING MODAL FOR LANDING PAGE -->
<div id="bookingModal" class="fixed inset-0 z-50 hidden bg-black/60 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl border border-stone-200 w-full max-w-lg overflow-hidden transform scale-95 opacity-0 transition-all duration-300 flex flex-col max-h-[90vh]">
        <!-- Modal Header -->
        <div class="bg-[#2D5A27] text-white p-6 flex justify-between items-center">
            <div>
                <h3 id="modalTitle" class="text-xl font-bold font-serif">Pilih Paket</h3>
                <p class="text-xs text-green-100 font-light mt-1">Lengkapi formulir pemesanan catering di bawah ini</p>
            </div>
            <button onclick="closeBookingModal()" class="text-white/80 hover:text-white text-2xl font-semibold cursor-pointer">&times;</button>
        </div>

        <!-- Modal Body (Scrollable) -->
        <div class="p-6 overflow-y-auto flex-1 space-y-6">
            @guest
                <!-- Login Redirect Panel -->
                <div class="text-center py-8 space-y-4">
                    <span class="text-5xl block">🔒</span>
                    <h4 class="text-lg font-bold text-gray-900 font-serif">Autentikasi Diperlukan</h4>
                    <p class="text-sm text-gray-500 max-w-sm mx-auto font-light leading-relaxed">
                        Silakan masuk ke akun Anda terlebih dahulu untuk dapat melakukan pemesanan paket catering secara online.
                    </p>
                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
                        <a href="{{ route('auth.google.redirect') }}" class="w-full sm:w-auto flex items-center justify-center gap-2.5 bg-white hover:bg-stone-50 text-gray-700 font-semibold py-2.5 px-4 rounded-xl border border-stone-200 shadow-2xs hover:shadow-xs transition-all text-xs cursor-pointer">
                            <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                            </svg>
                            <span>Google Sign-In</span>
                        </a>
                        <a href="{{ route('login') }}" class="w-full sm:w-auto bg-[#3B420C] hover:bg-[#2C3109] text-white text-xs font-bold px-5 py-2.5 rounded-xl shadow-2xs transition-all">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="w-full sm:w-auto bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-bold px-4 py-2.5 rounded-xl border border-gray-200 transition-all">
                            Daftar Akun
                        </a>
                    </div>
                </div>
            @else
                <!-- Order Form -->
                <form id="orderForm" onsubmit="submitOrder(event)" class="space-y-5">
                    @csrf
                    <input type="hidden" name="items[0][paket_id]" id="inputPaketId">
                    <input type="hidden" name="items[0][jml_paket]" id="inputJmlPaket">

                    <!-- Paket Details Summary -->
                    <div class="bg-[#F8F8F2] border border-[#E5E5DC] rounded-2xl p-4 flex justify-between items-center">
                        <div>
                            <span class="text-xs text-gray-400 font-medium">Paket Terpilih</span>
                            <h4 id="selectedPaketName" class="text-base font-bold font-serif text-brand-green">Prasmanan</h4>
                        </div>
                        <div class="text-right">
                            <span class="text-xs text-gray-400 font-medium">Harga / Pax</span>
                            <h4 id="selectedPaketPriceLabel" class="text-base font-extrabold text-gray-800">Rp 50.000</h4>
                        </div>
                    </div>

                    <!-- Lauk Selection -->
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Pilih Lauk Pilihan (<span id="laukCounter">0</span>/<span id="maxLaukLabel">0</span>)
                        </label>
                        <p class="text-xs text-gray-400 mb-3 font-light">Pilih lauk yang Anda inginkan sesuai batas paket Anda.</p>
                        
                        <div class="grid grid-cols-2 gap-2 max-h-48 overflow-y-auto border border-gray-200 rounded-xl p-3 bg-[#FDFDFC]">
                            @foreach($lauks as $lauk)
                                <label class="flex items-center space-x-2 p-2 hover:bg-gray-50 rounded-lg cursor-pointer text-xs select-none">
                                    <input type="checkbox" name="lauk_ids[]" value="{{ $lauk->id }}" onchange="updateLaukSelection(this)" class="lauk-checkbox rounded text-brand-green focus:ring-brand-green border-gray-300 w-4 h-4">
                                    <span class="text-gray-700 font-medium">{{ $lauk->nama_lauk }}</span>
                                </label>
                            @endforeach
                        </div>
                        <p id="laukWarning" class="text-[11px] text-red-500 mt-1 hidden">Anda telah memilih batas maksimal lauk pauk.</p>
                    </div>

                    <!-- Pax Input -->
                    <div>
                        <label for="jumlahPaxInput" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Jumlah Pax / Porsi
                        </label>
                        <input type="number" id="jumlahPaxInput" name="jumlah_pax" min="10" value="50" required oninput="calculateLivePrice()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm">
                        <p class="text-[10px] text-gray-400 mt-1 font-light">Minimal pemesanan adalah 10 porsi (pax).</p>
                    </div>

                    <!-- Date Picker -->
                    <div>
                        <label for="tglAcaraInput" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Tanggal Acara
                        </label>
                        <input type="date" id="tglAcaraInput" name="tgl_acara" required class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm">
                        <p class="text-[10px] text-gray-400 mt-1 font-light">Pemesanan harus dilakukan minimal H+1 dari hari ini.</p>
                    </div>

                    <!-- Gubukan Stall Selection -->
                    <div id="gubukanSelectionContainer">
                        <label for="gubukanSelect" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Stall Gubukan Tambahan (Opsional)
                        </label>
                        <select id="gubukanSelect" name="gubukan_id" onchange="calculateLivePrice()" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm bg-white">
                            <option value="" data-price="0">-- Tanpa Gubukan --</option>
                            @foreach($gubukans as $gubukan)
                                <option value="{{ $gubukan->id }}" data-price="{{ $gubukan->harga_gubukan }}">
                                    {{ $gubukan->nama_gubukan }} (+Rp {{ number_format($gubukan->harga_gubukan, 0, ',', '.') }} | Kp. {{ $gubukan->kapasitas_orang }} org)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Catatan -->
                    <div>
                        <label for="catatanTextarea" class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea id="catatanTextarea" name="catatan" rows="2" placeholder="Misal: Tolong level pedas sedang, pisahkan saus, dll." class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-brand-green text-sm"></textarea>
                    </div>

                    <!-- Error Banner -->
                    <div id="errorBanner" class="hidden bg-red-50 border-l-4 border-red-500 p-4 rounded-xl">
                        <div class="flex">
                            <div class="flex-shrink-0 text-red-500">⚠️</div>
                            <div class="ml-3">
                                <p id="errorText" class="text-xs text-red-700 font-medium"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Live Price Calculation Panel -->
                    <div class="bg-[#2D5A27]/5 border border-[#2D5A27]/10 rounded-2xl p-4 space-y-2">
                        <div class="flex justify-between items-center text-xs text-gray-600 font-light">
                            <span>Subtotal Paket (<span id="calcPaxLabel">50</span> x <span id="calcPriceLabel">Rp 0</span>)</span>
                            <span id="calcSubtotalPaket">Rp 0</span>
                        </div>
                        <div id="calcGubukanRow" class="flex justify-between items-center text-xs text-gray-600 font-light hidden">
                            <span>Stall Gubukan</span>
                            <span id="calcGubukanPrice">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center pt-2 border-t border-brand-green/10">
                            <span class="text-sm font-bold text-gray-800">Total Harga</span>
                            <span id="calcTotalPrice" class="text-base font-extrabold text-brand-green">Rp 0</span>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" id="submitBtn" class="w-full bg-[#3B420C] hover:bg-[#2C3109] text-white font-bold py-3.5 rounded-xl transition-all shadow-md flex items-center justify-center gap-2 cursor-pointer">
                        <span>Pesan Sekarang</span>
                        <div id="submitSpinner" class="hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    </button>
                </form>
            @endguest
        </div>
    </div>
</div>
