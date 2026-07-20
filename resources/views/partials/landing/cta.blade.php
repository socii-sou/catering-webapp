<!-- CTA SECTION (Subscription Banner) -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#3B420C] rounded-3xl p-8 sm:p-12 lg:p-16 text-white text-center shadow-xl relative overflow-hidden">
            <!-- Overlay shapes -->
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/5 rounded-full"></div>
            <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-white/5 rounded-full"></div>
            
            <div class="relative z-10 max-w-2xl mx-auto">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-serif mb-4">Siap untuk Acara yang Berkesan?</h2>
                <p class="text-sm text-green-100 mb-8 font-light">
                    Konsultasikan kebutuhan catering Anda sekarang dan dapatkan penawaran khusus untuk pemesanan pertama.
                </p>
                
                <form onsubmit="event.preventDefault(); alert('Terima kasih! Anda telah terdaftar dalam newsletter kami.'); this.reset();" class="flex flex-col sm:flex-row items-stretch gap-3 max-w-md mx-auto">
                    <input type="email" placeholder="Alamat Email Anda" required class="flex-1 px-4 py-3 rounded-lg bg-white/10 text-white placeholder-green-200 border border-white/20 focus:outline-none focus:ring-2 focus:ring-white/40 text-sm">
                    <button type="submit" class="bg-white text-[#3B420C] hover:bg-green-50 font-bold px-6 py-3 rounded-lg transition-colors text-sm shadow-sm cursor-pointer">
                        Mulai Berlangganan
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
