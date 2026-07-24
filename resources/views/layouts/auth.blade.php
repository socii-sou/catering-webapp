<!DOCTYPE html>
<html lang="id" class="h-full bg-stone-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Autentikasi') - Rasaci Catering</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Meta Description for SEO -->
    <meta name="description" content="Masuk atau daftar ke akun Rasaci Catering untuk menikmati cita rasa hidangan autentik terbaik.">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    <!-- Style & Script via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-stone-900 flex items-center justify-center p-4 sm:p-6 md:p-8">

    <div class="w-full max-w-5xl bg-white rounded-3xl shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[600px] lg:min-h-[655px] border border-stone-200/50">
        
        <!-- Left Side: Banner (Hidden on mobile, visible on medium screens) -->
        <div class="relative hidden md:flex md:w-1/2 bg-stone-900 text-white flex-col justify-between p-8 lg:p-12 overflow-hidden bg-cover bg-center select-none" style="background-image: linear-gradient(to bottom, rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.75)), url('{{ asset('images/hero_banner.jpg') }}');">
            <!-- Brand Name -->
            <div class="z-10">
                <a href="/" class="inline-block">
                    <span class="text-3xl font-bold font-serif text-white tracking-widest">RASACI</span>
                    <div class="h-1 w-10 bg-[#2D5A27] mt-1"></div>
                </a>
            </div>

            <!-- Bottom Brand Info -->
            <div class="z-10 space-y-6">
                <div class="space-y-3">
                    <h2 class="text-xl lg:text-2xl font-serif font-semibold text-white leading-snug">
                        Cita Rasa Autentik di Setiap Hidangan.
                    </h2>
                    <p class="text-xs lg:text-sm text-stone-300 font-light leading-relaxed">
                        Kami menghadirkan kehangatan masakan rumah dengan kualitas restoran bintang lima untuk setiap momen spesial Anda.
                    </p>
                </div>
                
                <div class="flex items-center space-x-2 text-white text-[11px] font-bold tracking-wider uppercase select-none">
                    <!-- Shield Check Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                    </svg>
                    <span>KEPERCAYAAN & KUALITAS TERJAMIN</span>
                </div>
            </div>
        </div>

        <!-- Right Side: Forms -->
        <div class="w-full md:w-1/2 flex flex-col justify-between p-8 lg:p-12 bg-white relative">
            @yield('content')
        </div>

    </div>

</body>
</html>
