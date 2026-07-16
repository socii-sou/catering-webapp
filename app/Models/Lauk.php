<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lauk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lauk',
        'kategori_lauk_id',
        'keterangan',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

    /*
    |--------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------
    */

    public function kategoriLauk(): BelongsTo
    {
        return $this->belongsTo(KategoriLauk::class);
    }

    public function pesananPaketLauks(): HasMany
    {
        return $this->hasMany(PesananPaketLauk::class);
    }
}