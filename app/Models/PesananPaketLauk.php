<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PesananPaketLauk extends Model
{
    use HasFactory;

    /**
     * Nama tabel di-set eksplisit karena tidak mengikuti
     * konvensi plural bawaan Laravel (pesanan_paket_lauk, bukan pesanan_paket_lauks).
     */
    protected $table = 'pesanan_paket_lauk';

    protected $fillable = [
        'pesanan_paket_id',
        'lauk_id',
    ];

    public function pesananPakets(): BelongsTo
    {
        return $this->belongsTo(PesananPaket::class);
    }

    public function lauk(): BelongsTo
    {
        return $this->belongsTo(Lauk::class);
    }
}