<?php

namespace App\Notifications;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PesananBerhasilDibuat extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Pesanan $pesanan)
    {
    }

    /**
     * Channel notifikasi yang dipakai. Cukup 'mail' untuk sekarang,
     * nanti gampang ditambah 'database' atau 'whatsapp' kalau perlu.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesanan #' . $this->pesanan->id . ' Berhasil Dibuat')
            ->greeting('Halo, ' . $notifiable->name . '!')
            ->line('Terima kasih, pesanan kamu sudah kami terima dan sedang menunggu validasi dari tim kami.')
            ->line('Tanggal acara: ' . $this->pesanan->tgl_acara->format('d F Y'))
            ->line('Jumlah pax: ' . $this->pesanan->jumlah_pax)
            ->line('Total harga: Rp ' . number_format((float) $this->pesanan->total_harga, 0, ',', '.'))
            ->action('Lihat Detail Pesanan', url('/pesanan/' . $this->pesanan->id))
            ->line('Kami akan menginformasikan lebih lanjut setelah pesanan divalidasi.');
    }
}