@extends('layouts.auth')

@section('title', 'Verifikasi OTP - Langkah 2')

@section('content')
<div class="flex-1 flex flex-col justify-center">
    
    <!-- Title Header -->
    <div class="mb-4 text-center sm:text-left">
        <h2 class="text-2xl font-serif font-bold text-stone-900">Verifikasi Kode OTP</h2>
        <p class="text-xs text-stone-500 font-light mt-1">
            Kode verifikasi 6-digit telah dikirimkan ke <strong class="text-stone-800 font-semibold">{{ session('register_email') }}</strong>.
        </p>
    </div>

    <!-- Visual Timeline Stepper (Step 2 Active) -->
    <div class="mb-7 px-2">
        <div class="flex items-center justify-between relative max-w-xs mx-auto">
            <!-- Background Line -->
            <div class="absolute top-4 left-6 right-6 h-0.5 bg-stone-200 z-0"></div>
            <!-- Active Line Progress (50% for Step 2) -->
            <div class="absolute top-4 left-6 w-1/2 h-0.5 bg-[#2D5A27] z-0 transition-all duration-300"></div>

            <!-- Step 1: Completed -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-bold text-xs flex items-center justify-center shadow-md ring-4 ring-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <span class="text-[11px] font-semibold text-[#2D5A27] mt-1.5 whitespace-nowrap">Data Diri</span>
            </div>

            <!-- Step 2: Active -->
            <div class="flex flex-col items-center z-10">
                <div class="w-8 h-8 rounded-full bg-[#2D5A27] text-white font-bold text-xs flex items-center justify-center shadow-md ring-4 ring-white">
                    2
                </div>
                <span class="text-[11px] font-bold text-[#2D5A27] mt-1.5 whitespace-nowrap">Verifikasi OTP</span>
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

    <!-- Session Success / Alert Messages -->
    @if (session('success'))
        <div class="mb-5 p-3.5 bg-emerald-50 border-l-4 border-emerald-500 rounded-r-lg text-xs text-emerald-800 font-medium">
            {{ session('success') }}
        </div>
    @endif

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

    <!-- OTP Input Form -->
    <form action="{{ route('register.otp.verify') }}" method="POST" class="space-y-5">
        @csrf

        <div class="space-y-2">
            <label for="otp" class="text-xs font-semibold text-gray-700 block text-center">
                Masukkan Kode OTP (6 Angka)
            </label>
            <div class="relative">
                <input 
                    type="text" 
                    name="otp" 
                    id="otp" 
                    maxlength="6"
                    pattern="[0-9]{6}"
                    inputmode="numeric"
                    placeholder="123456" 
                    required
                    autofocus
                    class="block w-full text-center tracking-[12px] text-2xl font-bold font-mono py-3.5 bg-[#F1F3EA] border border-[#2D5A27]/30 rounded-xl text-stone-900 placeholder-stone-300 focus:outline-hidden focus:ring-2 focus:ring-[#2D5A27]/30 focus:border-[#2D5A27] focus:bg-white transition-all"
                />
            </div>
            <p class="text-[11px] text-stone-400 text-center font-light">Periksa kotak masuk atau folder Spam email Anda.</p>
        </div>

        <!-- Submit Button -->
        <div>
            <button 
                type="submit" 
                class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border border-transparent rounded-xl shadow-md text-base font-serif font-bold text-white bg-[#2D5A27] hover:bg-[#1e3f1a] active:bg-[#142a11] focus:outline-hidden focus:ring-2 focus:ring-offset-2 focus:ring-[#2D5A27] transition-all cursor-pointer transform hover:-translate-y-0.5 active:translate-y-0 duration-150"
            >
                <span>Verifikasi Kode OTP</span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </button>
        </div>
    </form>

    <!-- Resend OTP & Option to Change Email -->
    <div class="mt-6 flex flex-col items-center space-y-3 text-xs">
        <form action="{{ route('register.otp.resend') }}" method="POST" class="w-full text-center">
            @csrf
            <span class="text-stone-500 font-light">Tidak menerima kode? </span>
            <button type="submit" class="font-bold text-[#2D5A27] hover:underline cursor-pointer">
                Kirim Ulang OTP
            </button>
        </form>

        <a href="{{ route('register') }}" class="text-stone-400 hover:text-stone-600 font-light flex items-center gap-1">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-3.5 h-3.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
            </svg>
            <span>Ubah Alamat Email</span>
        </a>
    </div>

</div>

<!-- Footer Copyright -->
<div class="mt-6 text-center text-[10px] text-stone-400 font-medium tracking-wide">
    &copy; {{ date('Y') }} RASACI. Seluruh hak cipta dilindungi.
</div>
@endsection
