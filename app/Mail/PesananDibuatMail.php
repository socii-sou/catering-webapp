<?php

namespace App\Mail;

use App\Models\Pesanan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PesananDibuatMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Pesanan $pesanan)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pesanan Baru #ORD-' . str_pad($this->pesanan->id, 5, '0', STR_PAD_LEFT) . ' - RASACI Catering',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pesanan_dibuat',
        );
    }
}
