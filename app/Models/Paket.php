<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Paket extends Model
{
    use HasFactory;

    protected $fillable = [
        'nm_paket',
        'harga_paket',
        'jumlah_lauk_pilihan',
        'deskripsi',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga_paket' => 'decimal:2',
            'jumlah_lauk_pilihan' => 'integer',
            'status_aktif' => 'boolean',
        ];
    }

    public function pesananPakets(): HasMany
    {
        return $this->hasMany(PesananPaket::class);
    }
}