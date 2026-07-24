@extends('layouts.admin')

@section('title', 'Ulasan & Review - Admin RASACI')

@section('content')
<div class="space-y-6">

    <!-- Top Action & Header Banner -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 border border-[#E5E5DC] shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-6 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-[#2D5A27]/10 rounded-full blur-2xl pointer-events-none"></div>
        <div class="z-10">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-[#2D5A27]/10 text-[#2D5A27] mb-3">
                <svg class="w-4 h-4 text-[#2D5A27]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <span>Moderasi Ulasan</span>
            </span>
            <h2 class="text-2xl sm:text-3xl font-serif font-bold text-gray-900 tracking-tight">
                Review & Ulasan Pesanan
            </h2>
            <p class="text-xs text-gray-500 font-light mt-1 max-w-xl">
                Pantau feedback dari pelanggan dan moderasi ulasan yang tidak pantas atau terindikasi spam.
            </p>
        </div>
    </div>

    <!-- Alert Success Notifications -->
    @if (session('success'))
        <div class="p-4 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-2xl text-emerald-800 text-xs font-semibold shadow-2xs flex items-center gap-2.5">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Review Metrics Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Card 1: Total Review -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($totalReviews) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Total Ulasan</span>
            </div>
        </div>

        <!-- Card 2: Rata-rata Rating -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($avgRating, 1) }} <span class="text-xs text-gray-400 font-normal">/ 5.0</span></span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Rata-rata Rating</span>
            </div>
        </div>

        <!-- Card 3: Rating 5 Bintang -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($fiveStarCount) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Rating 5 Bintang</span>
            </div>
        </div>

        <!-- Card 4: Rating Rendah -->
        <div class="bg-white rounded-2xl p-5 border border-[#E5E5DC] shadow-2xs flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-700 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold text-gray-900">{{ number_format($lowRatingCount) }}</span>
                <span class="block text-xs text-gray-500 font-medium mt-0.5">Rating Rendah (1-2★)</span>
            </div>
        </div>
    </div>

    <!-- Search & Filter Card -->
    <div class="bg-white rounded-2xl p-4 sm:p-5 border border-[#E5E5DC] shadow-2xs">
        <form action="{{ route('penjual.reviews') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full sm:w-auto flex-1">
                <!-- Search Input -->
                <div class="relative w-full sm:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ $search }}" 
                        placeholder="Cari ulasan, pelanggan, atau acara..." 
                        class="w-full pl-10 pr-4 py-2.5 bg-[#F1F3EA] border border-transparent rounded-xl text-xs text-gray-900 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all"
                    />
                </div>

                <!-- Rating Filter Dropdown -->
                <select name="rating" onchange="this.form.submit()" class="w-full sm:w-48 px-3.5 py-2.5 bg-[#F1F3EA] border border-transparent rounded-xl text-xs font-semibold text-gray-700 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] cursor-pointer">
                    <option value="">Semua Rating</option>
                    <option value="5" {{ $rating == '5' ? 'selected' : '' }}>5 Bintang</option>
                    <option value="4" {{ $rating == '4' ? 'selected' : '' }}>4 Bintang</option>
                    <option value="3" {{ $rating == '3' ? 'selected' : '' }}>3 Bintang</option>
                    <option value="2" {{ $rating == '2' ? 'selected' : '' }}>2 Bintang</option>
                    <option value="1" {{ $rating == '1' ? 'selected' : '' }}>1 Bintang</option>
                </select>

                <button type="submit" class="px-4 py-2.5 bg-[#2D5A27] hover:bg-[#1e3f1a] text-white text-xs font-bold rounded-xl transition-all shadow-2xs cursor-pointer w-full sm:w-auto">
                    Cari
                </button>

                @if($search || $rating)
                    <a href="{{ route('penjual.reviews') }}" class="px-3.5 py-2.5 bg-stone-100 hover:bg-stone-200 text-stone-600 text-xs font-medium rounded-xl transition-all text-center w-full sm:w-auto">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Reviews Data Table -->
    <div class="bg-white rounded-3xl border border-[#E5E5DC] shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-[#F8F8F2] border-b border-[#E5E5DC] text-gray-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Pesanan / Acara</th>
                        <th class="px-6 py-4">Rating</th>
                        <th class="px-6 py-4">Ulasan</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#E5E5DC] text-gray-700 font-medium">
                    @forelse($reviews as $r)
                        <tr class="hover:bg-[#F8F8F2]/60 transition-colors">
                            <!-- Pelanggan Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img 
                                        src="{{ $r->user ? $r->user->avatar_url : 'https://ui-avatars.com/api/?name=Anonim' }}" 
                                        alt="{{ $r->user->name ?? 'Pelanggan' }}" 
                                        class="w-10 h-10 rounded-full object-cover border-2 border-[#2D5A27]/20 shadow-2xs"
                                    />
                                    <div>
                                        <span class="block font-bold text-gray-900 text-sm">{{ $r->user->name ?? 'Anonim' }}</span>
                                        <span class="block text-gray-500 font-light text-xs">{{ $r->user->email ?? '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Pesanan / Acara Info -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div>
                                    <span class="block font-bold text-gray-900 text-xs">
                                        {{ $r->pesanan->nama_acara ?? 'Pesanan #' . $r->pesanan_id }}
                                    </span>
                                    <span class="block text-gray-500 text-[11px] font-light">
                                        @if($r->pesanan && $r->pesanan->pesananPaket->isNotEmpty())
                                            {{ $r->pesanan->pesananPaket->first()->paket->nm_paket ?? 'Paket Katering' }}
                                        @else
                                            Paket Katering
                                        @endif
                                    </span>
                                </div>
                            </td>

                            <!-- Rating Stars -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-1 text-amber-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $r->rating)
                                            <svg class="w-4 h-4 text-amber-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4 text-stone-300 fill-current" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                    <span class="ml-1 text-xs font-bold text-gray-900">({{ $r->rating }})</span>
                                </div>
                            </td>

                            <!-- Isi Ulasan -->
                            <td class="px-6 py-4">
                                <p class="text-gray-800 text-xs leading-relaxed max-w-md italic bg-stone-50 p-2.5 rounded-xl border border-stone-200">
                                    "{{ $r->ulasan }}"
                                </p>
                            </td>

                            <!-- Tanggal Ulasan -->
                            <td class="px-6 py-4 whitespace-nowrap text-gray-500">
                                {{ $r->created_at ? $r->created_at->translatedFormat('d M Y, H:i') : '-' }}
                            </td>

                            <!-- Action Column: Tombol Hapus -->
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <button 
                                    type="button" 
                                    onclick="confirmDeleteReview({{ $r->id }}, '{{ addslashes($r->user->name ?? 'Pengguna') }}', '{{ addslashes($r->pesanan->nama_acara ?? 'Pesanan') }}')"
                                    class="px-3.5 py-1.5 bg-rose-50 border border-rose-200 text-rose-700 hover:bg-rose-100 rounded-xl text-xs font-semibold transition-colors cursor-pointer inline-flex items-center justify-center gap-1.5 shadow-2xs"
                                >
                                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    <span>Hapus Review</span>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <div class="space-y-2 flex flex-col items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <p class="font-medium text-gray-500">Belum ada ulasan dari pelanggan yang ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Bar -->
        @if($reviews->hasPages())
            <div class="px-6 py-4 bg-[#F8F8F2] border-t border-[#E5E5DC]">
                {{ $reviews->links() }}
            </div>
        @endif
    </div>

</div>

<!-- DELETE REVIEW CONFIRMATION MODAL -->
<div id="deleteReviewModal" class="fixed inset-0 z-50 flex items-center justify-center hidden p-4">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-xs transition-opacity" onclick="closeDeleteReviewModal()"></div>

    <!-- Modal Content Card -->
    <div class="relative bg-white rounded-3xl p-6 sm:p-8 max-w-md w-full shadow-2xl border border-[#E5E5DC] z-10 space-y-6 transform transition-all scale-100">
        
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center text-xl shrink-0">
                <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-xl font-serif font-bold text-gray-900">Hapus Review Tidak Pantas?</h3>
                <p class="text-xs text-gray-500 font-light mt-1">
                    Apakah ulasan ini mengandung kata-kata tidak pantas, ujaran kebencian, atau spam?
                </p>
            </div>
        </div>

        <div class="p-4 bg-rose-50/70 border border-rose-100 rounded-2xl text-xs text-rose-900 space-y-1">
            <span class="block font-medium text-gray-600">Ulasan yang akan dihapus:</span>
            <span id="reviewModalUser" class="block font-bold text-sm text-gray-900"></span>
            <span id="reviewModalAcara" class="block text-stone-500 text-[11px] font-light"></span>
        </div>

        <!-- Form action updated via JS -->
        <form id="deleteReviewForm" action="" method="POST" class="flex items-center gap-3 pt-2">
            @csrf
            @method('DELETE')

            <button 
                type="button" 
                onclick="closeDeleteReviewModal()"
                class="flex-1 py-3 px-4 bg-stone-100 hover:bg-stone-200 text-stone-700 text-xs font-bold rounded-xl transition-all cursor-pointer text-center"
            >
                Batal
            </button>

            <button 
                type="submit" 
                class="flex-1 py-3 px-4 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition-all shadow-md cursor-pointer text-center"
            >
                Ya, Hapus Review
            </button>
        </form>
    </div>
</div>

<script>
    function confirmDeleteReview(reviewId, userName, namaAcara) {
        const modal = document.getElementById('deleteReviewModal');
        const form = document.getElementById('deleteReviewForm');
        const userEl = document.getElementById('reviewModalUser');
        const acaraEl = document.getElementById('reviewModalAcara');

        if (form && modal && userEl && acaraEl) {
            form.action = '/penjual/reviews/' + reviewId;
            userEl.textContent = 'Dari: ' + userName;
            acaraEl.textContent = 'Acara: ' + namaAcara;
            modal.classList.remove('hidden');
        }
    }

    function closeDeleteReviewModal() {
        const modal = document.getElementById('deleteReviewModal');
        if (modal) {
            modal.classList.add('hidden');
        }
    }
</script>
@endsection
