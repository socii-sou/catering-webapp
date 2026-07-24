<!-- HEADER / NAVBAR -->
<header class="sticky top-0 z-40 w-full bg-[#F8F8F2]/95 backdrop-blur-md border-b border-[#E5E5DC] py-3.5 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
        <!-- Logo & Mobile Menu Toggle -->
        <div class="flex items-center gap-3">
            <button type="button" onclick="toggleMobileMenu()" class="md:hidden p-2 text-gray-600 hover:text-brand-green focus:outline-none cursor-pointer rounded-lg hover:bg-black/5" title="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <a href="/" class="flex items-center space-x-2">
                <span class="text-xl sm:text-2xl font-bold tracking-widest font-serif text-brand-green">RASACI</span>
            </a>
        </div>

        <!-- Navigation Links (Desktop) -->
        <nav class="hidden md:flex space-x-8 text-sm font-medium">
            <a href="/#packages" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">Packages</a>
            <a href="/#how-it-works" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">How It Works</a>
            <a href="/#reviews" class="text-gray-600 hover:text-brand-green transition-colors py-2 border-b-2 border-transparent hover:border-brand-green">Reviews</a>
        </nav>

        <!-- Auth Buttons & Actions -->
        <div class="flex items-center space-x-2 sm:space-x-4">
            @auth
                @php
                    $activeOrdersCount = isset($myOrders) 
                        ? $myOrders->reject(fn($o) => in_array(strtolower($o->status_pesanan), ['batal', 'dibatalkan', 'ditolak']))->count()
                        : Auth::user()->pesanans()->whereNotIn('status_pesanan', ['batal', 'dibatalkan', 'ditolak'])->count();
                @endphp
                <a href="{{ route('pesanan.index') }}" class="text-gray-700 hover:text-brand-green text-xs sm:text-sm font-semibold transition-colors flex items-center gap-1.5 cursor-pointer bg-white sm:bg-transparent px-3 py-1.5 sm:p-0 rounded-xl border sm:border-0 border-gray-200 shadow-2xs sm:shadow-none">
                    <!-- Shopping Bag Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                    <span class="hidden sm:inline">Pesanan Saya</span>
                    <span class="sm:hidden">Pesanan</span>
                    @if($activeOrdersCount > 0)
                        <span class="bg-brand-green text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $activeOrdersCount }}</span>
                    @endif
                </a>
                
                <div class="h-4 w-px bg-gray-300 hidden md:block"></div>

                <a href="{{ Auth::user()->isPenjual() ? route('penjual.profile.edit') : route('profile.edit') }}" class="flex items-center gap-2 hover:opacity-90 transition-all group">
                    <img src="{{ Auth::user()->avatar_url }}" alt="{{ Auth::user()->name }}" class="w-8 h-8 rounded-full object-cover border border-brand-green/30 group-hover:scale-105 transition-transform shadow-xs">
                    <span class="text-gray-700 text-sm hidden sm:inline font-medium">Hai, <span class="text-brand-green group-hover:underline">{{ Auth::user()->name }}</span></span>
                </a>

                @if(Auth::user()->isPenjual())
                    <a href="/penjual/dashboard" class="text-xs bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-3 rounded-xl transition-all shadow-xs">Dashboard</a>
                @endif

                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-xs text-red-600 hover:text-red-800 font-semibold py-1.5 px-2.5 sm:px-3 rounded-xl border border-red-200 hover:bg-red-50 transition-all cursor-pointer">
                        Keluar
                    </button>
                </form>
            @else
                <button onclick="openLoginModal()" class="text-gray-600 hover:text-brand-green text-xs sm:text-sm font-semibold transition-colors cursor-pointer">
                    Pesanan Saya
                </button>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center bg-[#3B420C] hover:bg-[#2C3109] text-white text-xs sm:text-sm font-bold px-4 sm:px-5 py-2 rounded-xl transition-all shadow-xs">
                    Masuk
                </a>
            @endauth
        </div>
    </div>

    <!-- Mobile Navigation Drawer / Dropdown -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-[#E5E5DC] mt-3 pt-3 px-4 pb-2 space-y-2 bg-[#F8F8F2]">
        <a href="/#packages" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:bg-black/5 hover:text-brand-green">Packages</a>
        <a href="/#how-it-works" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:bg-black/5 hover:text-brand-green">How It Works</a>
        <a href="/#reviews" onclick="toggleMobileMenu()" class="block px-3 py-2 rounded-xl text-sm font-semibold text-gray-700 hover:bg-black/5 hover:text-brand-green">Reviews</a>
    </div>
</header>

<script>
    function toggleMobileMenu() {
        const menu = document.getElementById('mobileMenu');
        if (menu) {
            menu.classList.toggle('hidden');
        }
    }
</script>
