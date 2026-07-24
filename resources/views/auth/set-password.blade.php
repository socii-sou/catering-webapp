@extends('layouts.auth')

@section('title', 'Buat Password - Langkah 3')

@section('content')
<div class="flex-1 flex flex-col justify-center">
    
    <!-- Title Header -->
    <div class="mb-4 text-center sm:text-left">
        <h2 class="text-2xl font-serif font-bold text-stone-900">Buat Password Akun</h2>
        <p class="text-xs text-stone-500 font-light mt-1">
            Email Anda telah terverifikasi! Langkah terakhir, buat kata sandi untuk mengamankan akun Anda.
        </p>
    </div>

    <!-- Visual Timeline Stepper (Step 3 Active) -->
    <div class="mb-7 px-2">
        <div class="flex items-center justify-between relative max-w-xs mx-auto">
            <!-- Background Line -->
            <div class="absolute top-4 left-6 right-6 h-0.5 bg-stone-200 z-0"></div>
            <!-- Active Line Progress (100% for Step 3) -->
            <div class="absolute top-4 left-6 right-6 h-0.5 bg-[#2D5A27] z-0 transition-all duration-300"></div>

            <!-- Step 1: Completed -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-bold text-xs flex items-center justify-center shadow-md ring-4 ring-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-[#2D5A27] mt-1.5 whitespace-nowrap">Data Diri</span>
            </div>

            <!-- Step 2: Completed -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-bold text-xs flex items-center justify-center shadow-md ring-4 ring-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-[#2D5A27] mt-1.5 whitespace-nowrap">Verifikasi OTP</span>
            </div>

            <!-- Step 3: Active -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-bold text-xs flex items-center justify-center shadow-md ring-4 ring-white">
                    3
                </div>
                <span class="text-[11px] font-bold text-[#2D5A27] mt-1.5 whitespace-nowrap">Set Password</span>
            </div>
        </div>
    </div>

    <!-- Error Messages -->
    @if ($errors->any())
        <div class="mb-5 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Set Password Form -->
    <form action="{{ route('register.password.set') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Password Input -->
        <div class="space-y-1.5">
            <label for="password" class="text-xs font-semibold text-gray-700 block">
                Password Baru
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Minimal 8 karakter" 
                    required
                    autofocus
                    class="block w-full pl-12 pr-12 py-3 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 placeholder-stone-400 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all text-sm font-light"
                />
                <button 
                    type="button" 
                    id="toggle-password" 
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-gray-700 focus:outline-hidden"
                >
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Konfirmasi Password Input -->
        <div class="space-y-1.5">
            <label for="password_confirmation" class="text-xs font-semibold text-gray-700 block">
                Konfirmasi Password
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <input 
                    type="password" 
                    name="password_confirmation" 
                    id="password_confirmation" 
                    placeholder="••••••••" 
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
                <span>Selesaikan Registrasi & Masuk</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            </button>
        </div>
    </form>

</div>

<!-- Footer Copyright -->
<div class="mt-6 text-center text-[10px] text-stone-400 font-medium tracking-wide">
    &copy; {{ date('Y') }} RASACI. Seluruh hak cipta dilindungi.
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-password');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');

        toggleBtn.addEventListener('click', function() {
            const isPassword = passwordInput.getAttribute('type') === 'password';
            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
            
            if (isPassword) {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.815 7.815 3 3m-3-3-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                `;
            } else {
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                `;
            }
        });
    });
</script>
@endsection
