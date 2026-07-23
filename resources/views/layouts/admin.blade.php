<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - RASACI Kitchen Management')</title>

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
<body class="bg-[#F8F8F2] text-gray-900 font-sans antialiased min-h-screen flex">

    <!-- LEFT SIDEBAR -->
    <aside class="w-64 bg-[#EAEFE2]/90 border-r border-[#E5E5DC] flex flex-col justify-between p-6 h-screen sticky top-0 shrink-0 z-30">
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
                    <span class="text-base">📊</span>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('penjual.packages') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/packages*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <span class="text-base">🍱</span>
                    <span>Packages</span>
                </a>

                <a href="{{ route('penjual.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/orders*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <span class="text-base">📦</span>
                    <span>Orders</span>
                </a>

                <a href="{{ route('penjual.reports') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl font-bold text-xs transition-all shadow-xs {{ request()->is('penjual/reports*') ? 'bg-[#2D5A27] text-white shadow-md' : 'text-gray-700 hover:bg-black/5 hover:text-[#2D5A27]' }}">
                    <span class="text-base">📈</span>
                    <span>Reports</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Bottom Actions -->
        <div class="space-y-4 pt-4 border-t border-[#D8E0CE]">
            <!-- Action Button -->
            <a href="/#packages" class="w-full bg-[#2D5A27] hover:bg-[#1E3E1A] text-white font-bold py-3.5 px-4 rounded-xl shadow-md flex items-center justify-center gap-2 text-xs transition-all cursor-pointer">
                <span>+</span>
                <span>New Package</span>
            </a>

            <div class="space-y-1 text-xs">
                <a href="#" class="flex items-center gap-2 px-3 py-2 text-gray-600 hover:text-gray-900 font-medium transition-colors">
                    <span>❓</span>
                    <span>Help</span>
                </a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-red-600 hover:text-red-800 font-medium transition-colors cursor-pointer">
                        <span>🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- RIGHT MAIN CONTENT WRAPPER -->
    <div class="flex-1 min-w-0 flex flex-col">
        <!-- TOP HEADER BAR -->
        <header class="bg-[#F8F8F2] px-6 sm:px-10 py-6 flex items-center justify-between gap-4 border-b border-[#E5E5DC]">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold font-serif text-gray-900 tracking-tight">
                    Dashboard Overview
                </h1>
                <p class="text-xs text-gray-500 font-light mt-0.5">
                    Welcome back, Chef. Here's what's happening today at RASACI.
                </p>
            </div>

            <!-- Header Right Profile & Notification -->
            <div class="flex items-center gap-5">
                <!-- Notification Bell -->
                <button type="button" class="relative p-2 text-gray-600 hover:text-gray-900 transition-colors cursor-pointer rounded-full hover:bg-black/5">
                    <span class="text-xl">🔔</span>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></span>
                </button>

                <div class="h-6 w-px bg-gray-300"></div>

                <!-- User Profile -->
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <span class="block text-xs font-bold text-gray-900">PENJUAL</span>
                        <span class="block text-[10px] text-gray-500 font-medium">Kitchen Lead</span>
                    </div>
                    <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&q=80&w=120" alt="Avatar" class="w-10 h-10 rounded-full object-cover border border-[#2D5A27]">
                </div>
            </div>
        </header>

        <!-- MAIN CONTENT CONTAINER -->
        <main class="flex-1 p-6 sm:p-10 space-y-8">
            @yield('content')
        </main>
    </div>

    @yield('modals')
    @yield('scripts')
</body>
</html>
