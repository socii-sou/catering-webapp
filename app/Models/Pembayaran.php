<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'jenis_pembayaran',
        'tgl_bayar',
        'jml_bayar',
        'metode_bayar',
        'status_bayar',
        'bukti_bayar',
        'snap_token',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'tgl_bayar' => 'datetime',
            'jml_bayar' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------
    */

    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}