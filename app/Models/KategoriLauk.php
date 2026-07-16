<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class KategoriLauk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kategori',
    ];

    public function lauks(): HasMany
    {
        return $this->hasMany(Lauk::class);
    }

    public function paketKuota(): HasMany
    {
        return $this->hasMany(PaketKategoriKuota::class);
    }
}