<!-- REVIEWS SECTION -->
<section id="reviews" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-xs font-semibold tracking-widest text-brand-green uppercase block mb-2">Testimoni</span>
            <h2 class="text-3xl sm:text-4xl font-bold font-serif text-gray-900">Apa Kata Mereka?</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto">
            @forelse($reviews as $review)
                <!-- Review Card -->
                <div class="bg-cream-card rounded-2xl p-8 border border-[#E5E5DC] flex flex-col justify-between hover:shadow-sm transition-shadow">
                    <div>
                        <!-- Rating Stars -->
                        <div class="flex text-amber-500 mb-4">
                            @for($i = 0; $i < 5; $i++)
                                @if($i < $review->rating)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-gray-300">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499c.174-.29.641-.29.815 0l2.88 4.906 5.568.397c.328.023.458.423.208.638l-4.167 3.58 1.25 5.372c.074.316-.271.567-.534.397L12 15.654l-4.702 2.848c-.263.17-.608-.081-.534-.397l1.25-5.372-4.167-3.58c-.25-.215-.12-.615.208-.638l5.568-.397 2.88-4.906Z" />
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <blockquote class="text-gray-700 italic text-sm leading-relaxed mb-6 font-light">
                            "{{ $review->ulasan }}"
                        </blockquote>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-full bg-brand-green/20 text-brand-green flex items-center justify-center font-bold text-sm shrink-0">
                            {{ strtoupper(substr($review->user->name, 0, 2)) }}
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">{{ $review->user->name }}</h4>
                            <p class="text-xs text-gray-500 font-light">
                                {{ $review->user->email === 'anita@example.test' ? 'Ibu Rumah Tangga' : ($review->user->email === 'budi@example.test' ? 'Manager IT' : 'Pelanggan Terverifikasi') }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-2 text-center py-8">
                    <p class="text-gray-500 text-sm italic">Belum ada review dari pelanggan.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
