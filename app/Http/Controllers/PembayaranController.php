<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Pesanan;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    public function __construct(protected MidtransService $midtransService)
    {
    }

    /**
     * POST /pesanan/{pesanan}/bayar
     * Generate Snap Token buat munculin popup pembayaran Midtrans di frontend.
     */
    public function createSnapToken(Request $request, Pesanan $pesanan)
    {
        abort_unless($pesanan->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'jumlah_bayar' => ['required', 'numeric', 'min:1'],
        ]);

        $pembayaran = $this->midtransService->createSnapToken($pesanan, $data['jumlah_bayar']);

        return response()->json([
            'pembayaran_id' => $pembayaran->id,
            'snap_token' => $pembayaran->snap_token,
        ]);
    }

    /**
     * POST /webhook/midtrans
     * Endpoint yang didaftarkan di dashboard Midtrans sebagai Payment Notification URL.
     *
     * PENTING (production): sebelum dipakai serius, tambahkan verifikasi signature_key
     * dari Midtrans (sha512(order_id + status_code + gross_amount + ServerKey)) supaya
     * endpoint ini tidak bisa dipalsukan orang lain.
     */
    public function webhook(Request $request)
    {
        $orderId = $request->input('order_id');
        $transactionStatus = $request->input('transaction_status');
        $fraudStatus = $request->input('fraud_status');

        $pembayaran = Pembayaran::where('transaction_id', $orderId)->firstOrFail();

        $statusBayar = match (true) {
            $transactionStatus === 'capture' && $fraudStatus === 'accept' => 'lunas',
            $transactionStatus === 'settlement' => 'lunas',
            in_array($transactionStatus, ['deny', 'cancel', 'expire']) => 'gagal',
            $transactionStatus === 'pending' => 'pending',
            default => $pembayaran->status_bayar,
        };

        $pembayaran->update(['status_bayar' => $statusBayar]);

        return response()->json(['message' => 'OK']);
    }
}