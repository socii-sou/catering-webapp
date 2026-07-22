<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesanan - RASACI Catering</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #F8F9F3;
            margin: 0;
            padding: 0;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            border: 1px solid #E5E5DC;
        }
        .header {
            background-color: #2D5A27;
            padding: 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 1px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 13px;
            opacity: 0.9;
        }
        .content {
            padding: 30px;
        }
        .greeting {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #1A1A1A;
        }
        .card {
            background-color: #F4F7EE;
            border: 1px solid #D2E6CE;
            border-radius: 14px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .order-badge {
            display: inline-block;
            background-color: #2D5A27;
            color: #ffffff;
            font-size: 12px;
            font-weight: bold;
            padding: 4px 12px;
            border-radius: 20px;
            margin-bottom: 10px;
        }
        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px border #E5E5DC;
            font-size: 13px;
        }
        .detail-label {
            color: #666666;
        }
        .detail-value {
            font-weight: 600;
            color: #1A1A1A;
            text-align: right;
        }
        .total-box {
            background-color: #FDF0ED;
            border: 1px solid #F7D6CD;
            border-radius: 12px;
            padding: 15px;
            margin-top: 15px;
            text-align: center;
        }
        .total-box .dp-label {
            font-size: 11px;
            font-weight: bold;
            color: #A84325;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .total-box .dp-amount {
            font-size: 22px;
            font-weight: 900;
            color: #8A3017;
            margin-top: 2px;
        }
        .btn-cta {
            display: block;
            width: 100%;
            background-color: #3B420C;
            color: #ffffff !important;
            text-align: center;
            padding: 14px 0;
            border-radius: 12px;
            font-weight: bold;
            text-decoration: none;
            font-size: 14px;
            margin-top: 20px;
        }
        .footer {
            background-color: #F8F9F3;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #777777;
            border-top: 1px solid #E5E5DC;
        }
        .footer a {
            color: #2D5A27;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>RASACI CATERING</h1>
            <p>Sajian Spesial Pertemuan & Acara Anda</p>
        </div>

        <!-- Main Content -->
        <div class="content">
            <div class="greeting">
                Halo, {{ $pesanan->user->name }} 👋
            </div>

            <p style="font-size: 13px; line-height: 1.6; color: #555555; margin-bottom: 20px;">
                Terima kasih telah memesan layanan catering kami! Pesanan Anda telah berhasil tercatat di sistem kami dan sedang menunggu proses pembayaran / validasi.
            </p>

            <!-- Order Card -->
            <div class="card">
                <div class="order-badge">
                    ORDER #ORD-{{ str_pad($pesanan->id, 5, '0', STR_PAD_LEFT) }}
                </div>

                <div style="margin-top: 10px;">
                    <table width="100%" cellpadding="6" cellspacing="0" style="font-size: 13px;">
                        <tr>
                            <td style="color: #666666;">Nama Acara:</td>
                            <td align="right" style="font-weight: 600;">{{ $pesanan->nama_acara }}</td>
                        </tr>
                        <tr>
                            <td style="color: #666666;">Jadwal Pengiriman:</td>
                            <td align="right" style="font-weight: 600;">{{ \Carbon\Carbon::parse($pesanan->tgl_acara)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td style="color: #666666;">Jumlah Pax:</td>
                            <td align="right" style="font-weight: 600;">{{ $pesanan->jumlah_pax }} Pax</td>
                        </tr>
                        <tr>
                            <td style="color: #666666;">Alamat Pengiriman:</td>
                            <td align="right" style="font-weight: 600; max-width: 250px;">{{ $pesanan->alamat_pengiriman }}</td>
                        </tr>
                        @if($pesanan->gubukan)
                        <tr>
                            <td style="color: #666666;">Tambahan Gubukan:</td>
                            <td align="right" style="font-weight: 600;">{{ $pesanan->gubukan->nama_gubukan }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- DP 50% Amount -->
                <div class="total-box">
                    <div class="dp-label">Wajib Bayar (DP 50%)</div>
                    <div class="dp-amount">Rp {{ number_format($pesanan->total_harga * 0.5, 0, ',', '.') }}</div>
                    <div style="font-size: 11px; color: #666666; margin-top: 4px;">
                        Total Tagihan: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                    </div>
                </div>
            </div>

            <p style="font-size: 12px; color: #666666; line-height: 1.5;">
                Silakan lakukan pembayaran DP melalui metode QRIS Midtrans atau Transfer Bank resmi RASACI Catering untuk mengamankan slot pesanan Anda.
            </p>

            <a href="{{ url('/pesanan/' . $pesanan->id) }}" class="btn-cta">
                LIHAT DETAIL PESANAN SAYA
            </a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p style="margin: 0 0 8px 0;">Butuh bantuan? Hubungi Customer Service kami:</p>
            <p style="margin: 0 0 10px 0;">
                📱 WhatsApp: <a href="https://wa.me/6281389025947" target="_blank">0813-8902-5947</a> | ✉️ Email: <a href="mailto:rasaci.catering@gmail.com">rasaci.catering@gmail.com</a>
            </p>
            <p style="margin: 0; font-size: 11px; color: #999999;">
                &copy; {{ date('Y') }} RASACI Catering. All Rights Reserved.
            </p>
        </div>
    </div>

</body>
</html>
