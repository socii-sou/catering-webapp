<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Kode Verifikasi OTP - RASACI Catering</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f7f9f6;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 550px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1e8df;
        }
        .header {
            background-color: #2D5A27;
            padding: 35px 30px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .content {
            padding: 40px 30px;
            line-height: 1.6;
            text-align: center;
        }
        .content h2 {
            font-size: 20px;
            color: #2D5A27;
            margin-top: 0;
            margin-bottom: 12px;
        }
        .content p {
            margin-bottom: 20px;
            color: #555555;
            font-size: 15px;
        }
        .otp-box {
            background-color: #F1F3EA;
            border: 2px dashed #2D5A27;
            border-radius: 14px;
            padding: 20px;
            margin: 25px auto;
            display: inline-block;
            letter-spacing: 10px;
            font-size: 36px;
            font-weight: bold;
            color: #2D5A27;
        }
        .notice {
            background-color: #fff9e6;
            border-left: 4px border #f59e0b;
            padding: 12px 16px;
            border-radius: 8px;
            font-size: 13px;
            color: #854d0e;
            margin-top: 25px;
            text-align: left;
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
            <h2>Halo, {{ $name }}!</h2>
            <p>Terima kasih telah melakukan pendaftaran di RASACI Catering. Gunakan kode OTP di bawah ini untuk memverifikasi alamat email Anda:</p>
            
            <div class="otp-box">
                {{ $otp }}
            </div>

            <p style="font-size: 13px; color: #777; margin-top: 10px;">
                Kode OTP ini berlaku selama <strong>10 menit</strong>.
            </p>

            <div class="notice">
                🔒 <strong>Penting:</strong> Jangan berikan kode OTP ini kepada siapapun termasuk pihak yang mengatasnamakan RASACI Catering demi keamanan akun Anda.
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} RASACI Catering. Seluruh hak cipta dilindungi.<br>
            Email dikirim otomatis, tidak perlu membalas email ini.
        </div>
    </div>
</body>
</html>
