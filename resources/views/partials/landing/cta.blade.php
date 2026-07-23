<!-- CTA SECTION (Subscription/Consultation Banner) -->
<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#3D4B1E] rounded-[24px] p-8 sm:p-12 lg:p-16 text-white text-center shadow-xl relative overflow-hidden">
            <!-- Overlay shapes -->
            <div class="absolute -right-16 -top-16 w-48 h-48 bg-white/5 rounded-full"></div>
            <div class="absolute -left-16 -bottom-16 w-48 h-48 bg-white/5 rounded-full"></div>
            
            <div class="relative z-10 max-w-3xl mx-auto space-y-6">
                <div class="space-y-2">
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold font-serif text-[#FAF9F5] leading-tight">
                        Punya Acara Spesial dalam Waktu Dekat?
                    </h2>
                    <p class="text-sm text-gray-200/90 font-sans font-light max-w-xl mx-auto">
                        Konsultasikan pilihan menu, porsi, dan anggaran catering Anda gratis bersama tim kami.
                    </p>
                </div>
                
                <form id="ctaConsultationForm" onsubmit="handleCtaSubmit(event)" class="flex flex-col sm:flex-row items-center justify-center gap-3 max-w-lg mx-auto w-full">
                    <input type="text" id="ctaWaInput" placeholder="Nomor WhatsApp Anda (misal: 0812...)" required class="w-full sm:flex-1 px-5 py-3.5 rounded-xl bg-[#2D3915]/60 text-white placeholder-gray-300/80 border border-white/10 focus:outline-none focus:ring-2 focus:ring-white/40 text-sm">
                    <button type="submit" class="w-full sm:w-auto bg-white text-[#3D4B1E] hover:bg-[#FAF9F5] font-bold px-7 py-3.5 rounded-xl transition-all duration-300 text-sm shadow-md cursor-pointer whitespace-nowrap">
                        Konsultasi Gratis
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    function handleCtaSubmit(e) {
        e.preventDefault();
        const waNum = document.getElementById('ctaWaInput').value;
        const text = encodeURIComponent(`Halo Tim Rasaci Catering, saya ingin konsultasi mengenai rencana acara saya. Ini nomor WhatsApp saya: ${waNum}`);
        window.open(`https://wa.me/6281389025947?text=${text}`, '_blank');
        document.getElementById('ctaConsultationForm').reset();
    }
</script>
