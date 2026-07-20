<!-- PACKAGES SECTION -->
<section id="packages" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12">
            <div>
                <span class="text-xs font-semibold tracking-widest text-brand-green uppercase block mb-2">Paket Pilihan</span>
                <h2 class="text-3xl sm:text-4xl font-bold font-serif text-gray-900">Pilih Paket yang Sesuai dengan Kebutuhan Acara Anda</h2>
            </div>
            <a href="#packages" class="text-sm font-semibold text-brand-green hover:underline mt-4 sm:mt-0 inline-flex items-center gap-1">
                Lihat Semua Paket
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse($pakets as $index => $paket)
                @php
                    $images = [
                        asset('images/nasi_kotak.jpg'),
                        asset('images/prasmanan.jpg'),
                        asset('images/tumpeng.jpg'),
                    ];
                    $imageUrl = $images[$index % count($images)];
                @endphp
                
                <!-- Package Card -->
                <div class="bg-cream-card rounded-3xl border border-[#E5E5DC] overflow-hidden flex flex-col justify-between hover:shadow-lg transition-all group">
                    <div>
                        <!-- Image with zoom effect on card hover -->
                        <div class="h-64 overflow-hidden relative">
                            <img src="{{ $imageUrl }}" alt="{{ $paket->nm_paket }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <span class="absolute top-4 right-4 bg-brand-green text-white text-xs font-semibold py-1.5 px-3.5 rounded-full shadow-md">
                                Pilih {{ $paket->jumlah_lauk_pilihan }} Lauk
                            </span>
                        </div>
                        <div class="p-6">
                            <h3 class="text-xl font-bold font-serif mb-2 text-gray-900">{{ $paket->nm_paket }}</h3>
                            <p class="text-xs text-gray-400 mb-3 tracking-wider uppercase font-semibold">Catering Premium</p>
                            <p class="text-sm text-gray-600 mb-6 font-light leading-relaxed">
                                {{ $paket->deskripsi ?? 'Nikmati kelezatan paket pilihan kami dengan standar rasa terjamin untuk kepuasan tamu Anda.' }}
                            </p>
                        </div>
                    </div>
                    <div class="p-6 pt-0 border-t border-[#E5E5DC]/50 flex items-center justify-between bg-[#FDFDF6]/60">
                        <div>
                            <p class="text-xs text-gray-500 font-light">Mulai dari</p>
                            <p class="text-lg font-extrabold text-brand-green">Rp {{ number_format($paket->harga_paket, 0, ',', '.') }} <span class="text-xs font-normal text-gray-500">/ pax</span></p>
                        </div>
                        <!-- Lihat Detail Button -->
                        <a href="/paket/{{ $paket->id }}" class="inline-flex items-center justify-center bg-brand-green bg-brand-green-hover text-white text-xs font-semibold px-4 py-2 rounded-xl transition-all shadow-sm active:scale-95 duration-100">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500 text-sm italic">Belum ada paket aktif.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
