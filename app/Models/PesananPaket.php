<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PesananPaket extends Model
{
    use HasFactory;

    protected $table = 'pesanan_paket';

    protected $fillable = [
        'pesanan_id',
        'paket_id',
        'jml_paket',
    ];

    protected function casts(): array
    {
        return [
            'jml_paket' => 'integer',
        ];
    }


    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }

    public function lauks(): HasMany
    {
        return $this->hasMany(PesananPaketLauk::class);
    }
}