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
}