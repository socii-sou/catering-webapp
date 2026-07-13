<?php

namespace App\Observers;

use App\Models\Pesanan;
use App\Notifications\PesananBerhasilDibuat;

class PesananObserver
{
    /**
     * Dipanggil otomatis oleh Laravel setiap ada baris baru masuk ke tabel pesanans.
     */
    public function created(Pesanan $pesanan): void
    {
        $pesanan->user->notify(new PesananBerhasilDibuat($pesanan));
    }
}