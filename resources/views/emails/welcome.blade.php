<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Selamat Datang di RASACI Catering</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f7f9f6;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1e8df;
        }
        .header {
            background-color: #2D5A27;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
        }
        .content h2 {
            font-size: 20px;
            color: #2D5A27;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .content p {
            margin-bottom: 20px;
            color: #555555;
            font-size: 15px;
        }
        .features {
            background-color: #f1f3ea;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .feature-item {
            margin-bottom: 15px;
        }
        .feature-item:last-child {
            margin-bottom: 0;
        }
        .feature-title {
            font-weight: bold;
            color: #2D5A27;
            margin-bottom: 5px;
        }
        .feature-desc {
            font-size: 14px;
            color: #666666;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .button {
            display: inline-block;
            background-color: #2D5A27;
            color: #ffffff !important;
            text-decoration: none;
            padding: 14px 30px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 30px;
            box-shadow: 0 4px 10px rgba(45, 90, 39, 0.2);
            transition: all 0.2s ease;
        }
        .footer {
            background-color: #f7f9f6;
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #999999;
            border-top: 1px solid #e1e8df;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>RASACI CATERING</h1>
        </div>
        <div class="content">
            <h2>Halo, {{ $user->name }}!</h2>
            <p>Terima kasih telah bergabung bersama RASACI Catering. Kami sangat senang bisa menjadi bagian dari momen spesial dan kebutuhan konsumsi harian Anda.</p>
            
            <p>Berikut adalah layanan utama yang dapat Anda nikmati di platform kami:</p>
            
            <div class="features">
                <div class="feature-item">
                    <div class="feature-title">🍽️ Pilihan Paket Beragam</div>
                    <div class="feature-desc">Mulai dari Tumpeng premium, Prasmanan, hingga Gubukan untuk pesta besar Anda.</div>
                </div>
                <div class="feature-item">
                    <div class="feature-title">💳 Pembayaran DP Mudah</div>
                    <div class="feature-desc">Pembayaran uang muka aman dan instan terintegrasi dengan Payment Gateway (Midtrans).</div>
                </div>
                <div class="feature-item">
                    <div class="feature-title">🚚 Pengantaran Tepat Waktu</div>
                    <div class="feature-desc">Pengiriman pesanan dikelola dengan baik untuk memastikan hidangan sampai dalam keadaan segar.</div>
                </div>
            </div>

            <p>Silakan masuk ke akun Anda untuk mulai menjelajahi katalog menu terbaik kami.</p>

            <div class="button-container">
                <a href="{{ url('/') }}" class="button">Lihat Menu Catering</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} RASACI Catering. Seluruh hak cipta dilindungi.<br>
            Email dikirim otomatis, tidak perlu membalas email ini.
        </div>
    </div>
</body>
</html>
