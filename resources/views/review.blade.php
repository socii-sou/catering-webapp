<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Berikan Ulasan Anda - Noesalera Catering</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F3F6EB; /* Light green-cream background from the design */
            color: #2C3E28;
        }
        .font-serif {
            font-family: 'Playfair Display', Georgia, serif;
        }
        .star-btn {
            font-size: 2.25rem;
            color: #D1D5DB; /* Gray-300 */
            transition: color 0.2s ease-in-out, transform 0.1s ease;
            cursor: pointer;
        }
        .star-btn:hover {
            transform: scale(1.1);
        }
        .star-btn.active {
            color: #FBBF24; /* Amber-400 */
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col justify-between">

    <!-- TOP HEADER -->
    <header class="max-w-4xl w-full mx-auto px-6 py-6 flex items-center">
        <a href="{{ route('pesanan.show', $pesanan->id) }}" class="flex items-center gap-3 text-sm font-semibold text-gray-700 hover:text-[#2D5A27] transition-all">
            <span class="text-lg">←</span>
            <span>Noesalera</span>
        </a>
    </header>

    <!-- MAIN CONTAINER -->
    <main class="max-w-xl w-full mx-auto px-6 py-4 flex-1 flex flex-col justify-center space-y-8">
        
        <!-- TITLE SECTION -->
        <div class="text-center space-y-2">
            <h1 class="text-4xl font-extrabold font-serif text-[#2C4E25] tracking-tight">Berikan Ulasan Anda</h1>
            <p class="text-xs text-gray-500 font-medium">Pendapat Anda membantu kami menyajikan yang terbaik.</p>
        </div>

        @if(session('error'))
            <div class="p-4 rounded-2xl bg-red-100 border border-red-200 text-red-800 text-xs font-bold flex items-center gap-2">
                <span>⚠️</span>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @php
            $firstItem = $pesanan->pesananPaket->first();
            $paketName = $firstItem && $firstItem->paket ? $firstItem->paket->nm_paket : ($pesanan->nama_acara ?? 'Paket Catering');
            $imgUrl = 'https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&q=80&w=300';
            
            if ($firstItem && $firstItem->paket) {
                if (str_contains(strtolower($paketName), 'tumpeng')) {
                    $imgUrl = 'https://images.unsplash.com/photo-1544025162-d76694265947?auto=format&fit=crop&q=80&w=300';
                } elseif (str_contains(strtolower($paketName), 'prasmanan')) {
                    $imgUrl = 'https://images.unsplash.com/photo-1555244162-803834f70033?auto=format&fit=crop&q=80&w=300';
                }
            }
        @endphp

        <!-- CARD 1: LAST ORDER -->
        <div class="bg-white rounded-3xl p-5 border border-gray-150 shadow-xs flex items-center gap-4">
            <img src="{{ $imgUrl }}" alt="{{ $paketName }}" class="w-20 h-16 rounded-2xl object-cover border border-gray-100 shrink-0">
            <div>
                <span class="text-[9px] font-bold text-green-700 bg-green-50 px-2 py-0.5 rounded-full uppercase tracking-wider">PESANAN TERAKHIR</span>
                <h4 class="font-bold text-gray-900 text-sm mt-1">{{ $paketName }}</h4>
                <p class="text-[10px] text-gray-400 font-light mt-0.5">Dipesan pada {{ \Carbon\Carbon::parse($pesanan->tgl_pesan)->translatedFormat('d F Y') }}</p>
            </div>
        </div>

        <!-- FORM ULASAN -->
        <form action="{{ route('pesanan.review.store', $pesanan->id) }}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="rating" id="ratingInput" value="" required>

            <!-- CARD 2: RATING STARS -->
            <div class="bg-[#ECF0DF] rounded-3xl p-6 border border-gray-200 text-center space-y-3">
                <span class="font-bold text-gray-950 block text-xs tracking-wide">Bagaimana kualitas layanan kami?</span>
                <div class="flex items-center justify-center gap-2">
                    <span class="star-btn" data-value="1">★</span>
                    <span class="star-btn" data-value="2">★</span>
                    <span class="star-btn" data-value="3">★</span>
                    <span class="star-btn" data-value="4">★</span>
                    <span class="star-btn" data-value="5">★</span>
                </div>
            </div>

            <!-- SECTION 3: TEXTAREA -->
            <div class="space-y-2">
                <label class="font-bold text-gray-700 block text-xs">Ceritakan pengalaman Anda</label>
                <textarea name="ulasan" id="ulasanTextarea" rows="5" required placeholder="Tuliskan ulasan Anda mengenai rasa, pelayanan, atau kemasan kami..." class="w-full p-4 rounded-2xl border border-gray-200 bg-white text-xs font-medium focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-transparent shadow-2xs resize-none leading-relaxed"></textarea>
            </div>

            <!-- SUBMIT BUTTON -->
            <div class="pt-2 text-center space-y-4">
                <button type="submit" class="w-full bg-[#3B6230] hover:bg-[#2C4E25] text-white font-bold py-4 rounded-2xl transition-all shadow-md flex items-center justify-center gap-2 text-xs tracking-wider uppercase cursor-pointer">
                    <span>Kirim Ulasan</span>
                    <span>➔</span>
                </button>
                <p class="text-[10px] text-gray-400 font-light leading-relaxed">
                    Dengan menekan tombol kirim, Anda menyetujui <a href="#" class="underline hover:text-gray-600">Kebijakan Privasi</a> kami.
                </p>
            </div>
        </form>
    </main>

    <!-- FOOTER -->
    <footer class="border-t border-gray-200/50 bg-[#F3F6EB] py-6 text-xs text-gray-500">
        <div class="max-w-4xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-3">
            <span class="font-bold text-gray-700">Noesalera Catering</span>
            <span class="font-light">© 2024 Noesalera Catering. All rights reserved.</span>
            <div class="flex items-center gap-4 font-bold text-gray-700">
                <a href="#" class="hover:text-green-700">Instagram</a>
                <a href="https://wa.me/6281389025947" target="_blank" class="hover:text-green-700">WhatsApp</a>
            </div>
        </div>
    </footer>

    <!-- INTERACTIVE SCRIPTS -->
    <script>
        // Stars interactive selection logic
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('ratingInput');

        stars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingInput.value = value;
                
                // Toggle active stars
                stars.forEach(s => {
                    const sValue = s.getAttribute('data-value');
                    if (Number(sValue) <= Number(value)) {
                        s.classList.add('active');
                    } else {
                        s.classList.remove('active');
                    }
                });
            });
        });
    </script>
</body>
</html>
