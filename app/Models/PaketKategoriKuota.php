<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaketKategoriKuota extends Model
{
    use HasFactory;

    protected $table = 'paket_kategori_kuota';

    protected $fillable = [
        'paket_id',
        'kategori_lauk_id',
        'jumlah_pilihan',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_pilihan' => 'integer',
        ];
    }

    public function paket(): BelongsTo
    {
        return $this->belongsTo(Paket::class);
    }

    public function kategoriLauk(): BelongsTo
    {
        return $this->belongsTo(KategoriLauk::class);
    }
}