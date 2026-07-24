<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - RASACI Kitchen Management')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Tailwind CSS CDN & Fonts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'brand-green': '#2D5A27',
                        'brand-[#2D5A27]': '#2D5A27',
                        'brand-dark': '#1A3317',
                        'brand-cream': '#F8F8F2',
                        'brand-sage': '#EAEFE2',
                    },
                    fontFamily: {
                        serif: ['Playfair Display', 'serif'],
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @yield('styles')
</head>
<body class="bg-[#F8F8F2] text-gray-900 font-sans antialiased min-h-screen flex flex-col md:flex-row">

    <!-- DESKTOP LEFT SIDEBAR -->
    <aside class="hidden md:flex w-64 bg-[#EAEFE2]/90 border-r border-[#E5E5DC] flex-col justify-between p-6 h-screen sticky top-0 shrink-0 z-30">
        <div class="space-y-8">
            <!-- Brand Logo -->
            <div class="space-y-0.5">
                <a href="/penjual/dashboard" class="block">
                    <span class="text-2xl font-black font-serif tracking-widest text-[#2D5A27] block">RASACI</span>
                    <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block">KITCHEN MANAGEMENT</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <nav class="space-y-1.5">
                <a href="/penjual/dashboard" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/dashboard*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('penjual.packages') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/packages*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    <span>Packages</span>
                </a>

                <a href="{{ route('penjual.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/orders*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    <span>Orders</span>
                </a>

                <a href="{{ route('penjual.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/reports*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                    <span>Reports</span>
                </a>

                <a href="{{ route('penjual.users') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/users*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span>Daftar Pengguna</span>
                </a>

                <a href="{{ route('penjual.reviews') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/reviews*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                    <span>Ulasan & Review</span>
                </a>

                <a href="{{ route('penjual.profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/profile*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengaturan Profil</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom Actions -->
        <div class="space-y-4 pt-4 border-t border-[#D8E0CE]">
            <a href="/" class="w-full bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3.5 px-4 rounded-xl shadow-md flex items-center justify-center gap-2 text-xs transition-all cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                <span>Beranda</span>
            </a>

            <div class="space-y-1 text-xs">
                <a href="{{ route('penjual.profile.edit') }}" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    <svg class="w-4 h-4 text-stone-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span>Pengaturan Profil</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-red-600 hover:text-red-800 font-medium transition-colors cursor-pointer">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- MOBILE DRAWER SIDEBAR -->
    <div id="adminMobileDrawer" class="fixed inset-0 z-50 flex hidden md:hidden">
        <!-- Backdrop -->
        <div onclick="toggleAdminMobileSidebar()" class="fixed inset-0 bg-black/50 backdrop-blur-xs"></div>

        <!-- Drawer Content -->
        <div class="relative w-64 bg-[#EAEFE2] h-full p-6 flex flex-col justify-between space-y-6 z-10 shadow-2xl">
            <div class="space-y-6">
                <!-- Brand & Close -->
                <div class="flex items-center justify-between">
                    <div class="space-y-0.5">
                        <span class="text-xl font-black font-serif tracking-widest text-[#2D5A27] block">RASACI</span>
                        <span class="text-[9px] font-bold text-gray-500 uppercase tracking-widest block">KITCHEN MANAGEMENT</span>
                    </div>
                    <button onclick="toggleAdminMobileSidebar()" class="text-gray-500 hover:text-gray-800 text-lg p-1">✕</button>
                </div>

                <!-- Navigation Links -->
                <nav class="space-y-2">
                    <a href="/penjual/dashboard" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/dashboard*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <a href="{{ route('penjual.packages') }}" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/packages*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        <span>Packages</span>
                    </a>

                    <a href="{{ route('penjual.orders') }}" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/orders*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                        <span>Orders</span>
                    </a>

                    <a href="{{ route('penjual.reports') }}" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/reports*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Reports</span>
                    </a>

                    <a href="{{ route('penjual.users') }}" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/users*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Daftar Pengguna</span>
                    </a>

                    <a href="{{ route('penjual.reviews') }}" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/reviews*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        <span>Ulasan & Review</span>
                    </a>

                    <a href="{{ route('penjual.profile.edit') }}" onclick="toggleAdminMobileSidebar()" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all {{ request()->is('penjual/profile*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5' }}">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <span>Pengaturan Profil</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Actions -->
            <div class="space-y-3 pt-4 border-t border-[#D8E0CE]">
                <a href="/" class="w-full bg-[#2D5A27] text-white font-bold py-3 px-4 rounded-xl shadow-md flex items-center justify-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-red-600 font-bold text-xs">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- RIGHT MAIN CONTENT WRAPPER -->
    <div class="flex-1 min-w-0 flex flex-col">
        <!-- TOP HEADER BAR -->
        <header class="bg-[#F8F8F2] px-4 sm:px-10 py-4 sm:py-6 flex items-center justify-between gap-4 border-b border-[#E5E5DC]">
            <div class="flex items-center gap-3">
                <!-- Mobile Sidebar Toggle Button -->
                <button type="button" onclick="toggleAdminMobileSidebar()" class="md:hidden p-2 text-gray-700 hover:bg-black/5 rounded-xl transition-colors cursor-pointer" title="Buka Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <div>
                    <h1 class="text-xl sm:text-3xl font-extrabold font-serif text-gray-900 tracking-tight">
                        @yield('header_title', 'Admin Dashboard')
                    </h1>
                    <p class="text-xs text-gray-500 font-light mt-0.5 hidden sm:block">
                        @yield('header_subtitle', 'Selamat datang kembali, Chef. Kelola operasional katering RASACI di sini.')
                    </p>
                </div>
            </div>

            <!-- Header Right Profile & Notification -->
            <div class="flex items-center gap-3 sm:gap-5">
                <!-- Notification Bell -->
                {{-- <button type="button" class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors cursor-pointer rounded-full hover:bg-black/5">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                    </svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>

                <div class="h-6 w-px bg-gray-300"></div> --}}

                <!-- User Profile Header Link -->
                <a href="{{ route('penjual.profile.edit') }}" class="flex items-center gap-2.5 hover:opacity-80 transition-opacity cursor-pointer">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-gray-900 uppercase">{{ auth()->user()->name ?? 'PENJUAL' }}</span>
                        <span class="block text-[10px] text-gray-500 font-medium capitalize">{{ auth()->user()->role ?? 'Kitchen Lead' }}</span>
                    </div>
                    <img
                        src="{{ auth()->user() ? auth()->user()->avatar_url : 'https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&q=80&w=120' }}"
                        alt="Avatar"
                        class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border border-[#2D5A27] shadow-2xs"
                    />
                </a>
            </div>
        </header>

        <!-- MAIN CONTENT CONTAINER -->
        <main class="flex-1 p-4 sm:p-8 md:p-10 space-y-6 sm:space-y-8">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleAdminMobileSidebar() {
            const drawer = document.getElementById('adminMobileDrawer');
            if (drawer) {
                drawer.classList.toggle('hidden');
            }
        }
    </script>

    @yield('modals')
    @yield('scripts')
</body>
</html>
