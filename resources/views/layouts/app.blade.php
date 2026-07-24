<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'RASACI Catering')</title>

        <!-- Favicon -->
        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
        <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

        <!-- Meta Description for SEO -->
        <meta name="description" content="@yield('meta-description', 'RASACI Catering menghadirkan layanan catering bintang lima dengan cita rasa Nusantara autentik untuk pesta pernikahan, rapat kantor, syukuran, dan acara spesial Anda.')">

        <!-- Google Fonts: Playfair Display (Serif) & Plus Jakarta Sans (Sans-serif) -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Plus+Jakarta+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background-color: #F8F8F2; /* Cream/off-white background */
            }
            .font-serif {
                font-family: 'Playfair Display', Georgia, serif;
            }
            .text-brand-green {
                color: #2D5A27;
            }
            .bg-brand-green {
                background-color: #2D5A27;
            }
            .bg-brand-green-hover:hover {
                background-color: #21441D;
            }
            .border-brand-green {
                border-color: #2D5A27;
            }
            .bg-cream-card {
                background-color: #FDFDF6;
            }
            .ambient-shadow {
                box-shadow: 0 10px 25px -5px rgba(45, 90, 39, 0.05);
            }

            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(20px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            .animate-fade-in {
                animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            }
            .delay-200 {
                animation-delay: 0.2s;
            }
            .delay-400 {
                animation-delay: 0.4s;
            }
        </style>

        @yield('styles')
    </head>
    <body class="antialiased text-[#1b1b18] min-h-screen flex flex-col">

        <!-- HEADER / NAVBAR PARTIAL -->
        @include('partials.navbar')

        <!-- PAGE CONTENT -->
        @yield('content')

        <!-- FOOTER PARTIAL -->
        @include('partials.footer')

        <!-- MODALS PARTIAL -->
        @include('partials.modals')

        <!-- Page-specific modals -->
        @yield('modals')

        <!-- SHARED JAVASCRIPT -->
        <script>
            // OPEN & CLOSE LOGIN MODAL FOR GUESTS
            function openLoginModal() {
                const modal = document.getElementById('loginModal');
                if (!modal) return;
                
                const emailInput = document.getElementById('login_email');
                const passwordInput = document.getElementById('login_password');
                if (emailInput) emailInput.value = '';
                if (passwordInput) passwordInput.value = '';
                
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }

            function closeLoginModal() {
                const modal = document.getElementById('loginModal');
                if (!modal) return;
                modal.firstElementChild.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }



            function closeSuccessOverlay() {
                const overlay = document.getElementById('successOverlay');
                if (overlay) {
                    overlay.classList.add('hidden');
                }
                window.location.reload();
            }

            // OPEN & CLOSE ORDERS HISTORIES MODAL (My Orders)
            function openOrdersModal() {
                const modal = document.getElementById('ordersModal');
                if (!modal) return;
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.firstElementChild.classList.remove('scale-95', 'opacity-0');
                }, 10);
            }

            function closeOrdersModal() {
                const modal = document.getElementById('ordersModal');
                if (!modal) return;
                modal.firstElementChild.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            // PAY WITH MIDTRANS SNAP (Mock/Real Snap Token execution)
            function payOrder(pesananId, totalHarga) {
                const btn = event.target;
                const originalText = btn.innerText;
                btn.disabled = true;
                btn.innerText = 'Loading...';

                fetch(`/pesanan/${pesananId}/bayar`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        jenis_pembayaran: 'dp'
                    })
                })
                .then(response => {
                    return response.json().then(data => {
                        if (!response.ok) {
                            throw new Error(data.message || 'Gagal membuat invoice.');
                        }
                        return data;
                    });
                })
                .then(data => {
                    if (window.snap) {
                        window.snap.pay(data.snap_token, {
                            onSuccess: function(result) {
                                alert("Pembayaran berhasil!");
                                window.location.reload();
                            },
                            onPending: function(result) {
                                alert("Menunggu pembayaran Anda.");
                                window.location.reload();
                            },
                            onError: function(result) {
                                alert("Pembayaran gagal!");
                                window.location.reload();
                            },
                            onClose: function() {
                                alert('Anda menutup popup tanpa menyelesaikan pembayaran.');
                                window.location.reload();
                            }
                        });
                    } else {
                        alert(`[MOCK MIDTRANS] Snap Token: ${data.snap_token}. Pembayaran sukses untuk pesanan #${pesananId}`);
                        
                        fetch('/api/webhook/midtrans', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({
                                order_id: pesananId,
                                transaction_status: 'settlement'
                            })
                        }).then(() => {
                            window.location.reload();
                        });
                    }
                })
                .catch(error => {
                    alert(error.message);
                })
                .finally(() => {
                    btn.disabled = false;
                    btn.innerText = originalText;
                });
            }
        </script>

        <!-- Page-specific scripts -->
        @yield('scripts')

        <!-- Dynamic Midtrans Snap JS (Sandbox / Production) -->
        @php
            $snapJsUrl = config('services.midtrans.is_production')
                ? 'https://app.midtrans.com/snap/snap.js'
                : 'https://app.sandbox.midtrans.com/snap/snap.js';
        @endphp
        <script type="text/javascript" src="{{ $snapJsUrl }}" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    </body>
</html>
