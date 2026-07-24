@extends('layouts.auth')

@section('title', 'Daftar - Langkah 1')

@section('content')
<div class="flex-1 flex flex-col justify-center">

    <!-- Tabs -->
    <div class="flex border-b border-stone-200 mb-6 space-x-8 text-2xl font-serif">
        <a href="{{ route('login') }}" class="pb-3 font-medium text-stone-400 hover:text-stone-600 border-b-4 border-transparent transition-all">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="pb-3 font-bold border-b-4 border-[#2D5A27] text-gray-900 transition-all">
            Daftar
        </a>
    </div>

    <!-- Visual Timeline Stepper -->
    <div class="mb-7 px-2">
        <div class="flex items-center justify-between relative max-w-xs mx-auto">
            <!-- Background Line -->
            <div class="absolute top-4 left-6 right-6 h-0.5 bg-stone-200 z-0"></div>
            <!-- Active Line Progress (0% for Step 1) -->
            <div class="absolute top-4 left-6 w-0 h-0.5 bg-[#2D5A27] z-0 transition-all duration-300"></div>

            <!-- Step 1: Active -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-bold text-xs flex items-center justify-center shadow-md ring-4 ring-white">
                    1
                </div>
                <span class="text-[11px] font-bold text-[#2D5A27] mt-1.5 whitespace-nowrap">Data Diri</span>
            </div>

            <!-- Step 2: Pending -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-stone-100 border border-stone-300 text-stone-400 font-bold text-xs flex items-center justify-center ring-4 ring-white">
                    2
                </div>
                <span class="text-[11px] font-medium text-stone-400 mt-1.5 whitespace-nowrap">Verifikasi OTP</span>
            </div>

            <!-- Step 3: Pending -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-stone-100 border border-stone-300 text-stone-400 font-bold text-xs flex items-center justify-center ring-4 ring-white">
                    3
                </div>
                <span class="text-[11px] font-medium text-stone-400 mt-1.5 whitespace-nowrap">Set Password</span>
            </div>
        </div>
    </div>

    <!-- Error/Session Messages -->
    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('register') }}" method="POST" class="mt-10 space-y-4">
        @csrf

        <!-- Nama Lengkap Input -->
        <div class="space-y-1.5">
            <label for="name" class="text-xs font-semibold text-gray-700 block">
                Nama Lengkap
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    placeholder="Contoh: Budi Santoso"
                    required
                    class="block w-full pl-12 pr-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 placeholder-stone-400 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all text-sm font-light"
                />
            </div>
        </div>

        <!-- Email Input -->
        <div class="space-y-1.5">
            <label for="email" class="text-xs font-semibold text-gray-700 block">
                Alamat Email
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Zm0 0c0 1.657 1.007 3 2.25 3S21 13.657 21 12a9 9 0 1 0-2.636 6.364M16.5 12V8.25" />
                    </svg>
                </div>
                <input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    placeholder="Contoh: budi@email.com"
                    required
                    class="block w-full pl-12 pr-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 placeholder-stone-400 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all text-sm font-light"
                />
            </div>
            <p class="text-[11px] text-stone-500 font-light">Kode OTP 6-digit akan dikirimkan ke email ini.</p>
        </div>

        <!-- Nomor Telepon Input -->
        <div class="space-y-1.5">
            <label for="no_telp" class="text-xs font-semibold text-gray-700 block">
                Nomor Telepon / WhatsApp
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 18.75h3" />
                    </svg>
                </div>
                <input
                    type="tel"
                    name="no_telp"
                    id="no_telp"
                    value="{{ old('no_telp') }}"
                    placeholder="Contoh: 08123456789"
                    required
                    class="block w-full pl-12 pr-4 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 placeholder-stone-400 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all text-sm font-light"
                />
            </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button
                type="submit"
                class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-md text-base font-serif font-bold text-white bg-[#2D5A27] hover:bg-[#1e3f1a] active:bg-[#142a11] focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-[#2D5A27] transition-all cursor-pointer transform hover:-translate-y-0.5 active:translate-y-0 duration-150"
            >
                <span>Lanjutkan</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Social Login Divider -->
    <div class="mt-6 relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-stone-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="bg-white px-3 text-stone-500 font-light">
                Atau mendaftar dengan
            </span>
        </div>
    </div>

    <!-- Social Login Button -->
    <div class="mt-4 flex justify-center">
        <a
            href="{{ route('auth.google.redirect') }}"
            class="w-full flex items-center justify-center py-3 px-4 border border-stone-200 rounded-xl bg-white hover:bg-stone-50 active:bg-stone-100 transition-colors shadow-xs text-stone-700 font-semibold text-xs cursor-pointer"
        >
            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            Daftar dengan Google
        </a>
    </div>

</div>

<!-- Footer Copyright -->
<div class="mt-6 text-center text-[10px] text-stone-400 font-medium tracking-wide">
    &copy; {{ date('Y') }} RASACI. Seluruh hak cipta dilindungi.
</div>
@endsection
