<?php

namespace App\Services;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class MidtransService
{
    protected string $baseUrl;
    protected string $serverKey;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->baseUrl = config('services.midtrans.is_production')
            ? 'https://app.midtrans.com/snap/v1'
            : 'https://app.sandbox.midtrans.com/snap/v1';
    }

    /**
     * Minta Snap Token ke Midtrans, lalu simpan sebagai baris baru di tabel pembayarans.
     * order_id yang dikirim ke Midtrans disimpan di kolom transaction_id,
     * karena itu yang dipakai untuk mencocokkan saat webhook masuk.
     */
    public function createSnapToken(Pesanan $pesanan, float $jumlahBayar): Pembayaran
    {
        $orderId = 'PESANAN-' . $pesanan->id . '-' . Str::upper(Str::random(6));

        $response = Http::withBasicAuth($this->serverKey, '')
            ->acceptJson()
            ->post("{$this->baseUrl}/transactions", [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => (int) $jumlahBayar,
                ],
                'customer_details' => [
                    'first_name' => $pesanan->user->name,
                    'email' => $pesanan->user->email,
                    'phone' => $pesanan->user->no_telp,
                ],
            ])
            ->throw()
            ->json();

        return $pesanan->pembayarans()->create([
            'tgl_bayar' => now(),
            'jml_bayar' => $jumlahBayar,
            'metode_bayar' => 'midtrans',
            'status_bayar' => 'pending',
            'snap_token' => $response['token'],
            'transaction_id' => $orderId,
        ]);
    }

    /**
     * Verifikasi keaslian notifikasi webhook dari Midtrans.
     *
     * Midtrans mengirim `signature_key` yang seharusnya persis sama dengan
     * hasil sha512(order_id + status_code + gross_amount + ServerKey) yang
     * kita hitung sendiri di sini. Kalau tidak cocok, berarti request itu
     * BUKAN dari Midtrans (bisa jadi orang lain coba memalsukan status bayar).
     *
     * @param  array<string, mixed>  $payload  Body request webhook (request()->all())
     */
    public function verifySignature(array $payload): bool
    {
        $orderId = $payload['order_id'] ?? '';
        $statusCode = $payload['status_code'] ?? '';
        $grossAmount = $payload['gross_amount'] ?? '';
        $signatureKey = $payload['signature_key'] ?? '';

        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);

        return hash_equals($expected, (string) $signatureKey);
    }
}