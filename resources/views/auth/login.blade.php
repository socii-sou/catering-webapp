@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
<div class="flex-1 flex flex-col justify-center">
    
    <!-- Tabs -->
    <div class="flex border-b border-stone-200 mb-8 space-x-8 text-2xl font-serif">
        <a href="{{ route('login') }}" class="pb-3 font-bold border-b-4 border-[#2D5A27] text-gray-900 transition-all">
            Masuk
        </a>
        <a href="{{ route('register') }}" class="pb-3 font-medium text-stone-400 hover:text-stone-600 border-b-4 border-transparent transition-all">
            Daftar
        </a>
    </div>

    <!-- Error/Session Messages -->
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg text-sm text-red-700">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg text-sm text-green-700">
            {{ session('status') }}
        </div>
    @endif

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Email / Username Input -->
        <div class="space-y-2">
            <label for="login" class="text-xs font-semibold text-gray-700 block">
                Email atau Username
            </label>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <!-- User Outline Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <input 
                    type="text" 
                    name="login" 
                    id="login" 
                    value="{{ old('login') }}"
                    placeholder="Contoh: user@email.com" 
                    required
                    class="block w-full pl-12 pr-4 py-3.5 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 placeholder-stone-400 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all text-sm font-light"
                />
            </div>
        </div>

        <!-- Password Input -->
        <div class="space-y-2">
            <div class="flex justify-between items-center">
                <label for="password" class="text-xs font-semibold text-gray-700">
                    Password
                </label>
                <a href="#" class="text-[11px] font-semibold text-[#2D5A27] hover:text-[#1e3f1a] transition-colors">
                    Lupa Password?
                </a>
            </div>
            <div class="relative rounded-xl">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-gray-500">
                    <!-- Lock Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                    </svg>
                </div>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="••••••••" 
                    required
                    class="block w-full pl-12 pr-12 py-3.5 bg-[#F1F3EA] border border-transparent rounded-xl text-stone-900 placeholder-stone-400 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/20 focus:border-[#2D5A27] focus:bg-white transition-all text-sm font-light"
                />
                <button 
                    type="button" 
                    id="toggle-password" 
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600 focus:outline-hidden"
                >
                    <!-- Eye Icon (Show) -->
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Remember Me Checkbox -->
        <div class="flex items-center">
            <input 
                id="remember" 
                name="remember" 
                type="checkbox" 
                class="h-4 w-4 rounded border-stone-300 text-[#2D5A27] focus:ring-[#2D5A27] cursor-pointer"
            />
            <label for="remember" class="ml-2.5 text-xs text-stone-600 select-none cursor-pointer">
                Ingat saya di perangkat ini
            </label>
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md text-lg font-serif font-bold text-white bg-[#2D5A27] hover:bg-[#1e3f1a] active:bg-[#142a11] focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-[#2D5A27] transition-all cursor-pointer transform hover:-translate-y-0.5 active:translate-y-0 duration-150"
            >
                Masuk ke Akun
            </button>
        </div>
    </form>

    <!-- Social Login Divider -->
    <div class="mt-8 relative">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-stone-200"></div>
        </div>
        <div class="relative flex justify-center text-xs">
            <span class="bg-white px-3 text-stone-500 font-light">
                Atau lanjutkan dengan
            </span>
        </div>
    </div>

    <!-- Social Login Button -->
    <div class="mt-6 flex justify-center">
        <a 
            href="{{ route('auth.google.redirect') }}"
            class="w-full flex items-center justify-center py-3 px-4 border border-stone-200 rounded-xl bg-white hover:bg-stone-50 active:bg-stone-100 transition-colors shadow-xs text-stone-700 font-semibold text-xs cursor-pointer"
        >
            <!-- Google Logo SVG -->
            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22c-.62-.63-1.04-1.37-1.19-2.63z" fill="#FBBC05"/>
                <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
            </svg>
            Lanjutkan dengan Google
        </a>
    </div>

</div>

<!-- Footer Copyright -->
<div class="mt-8 text-center text-[10px] text-stone-400 font-medium tracking-wide">
    &copy; 2024 RASACI. Seluruh hak cipta dilindungi.
</div>

<!-- Tiny script for password visibility toggle -->
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
