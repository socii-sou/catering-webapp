<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lauk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_lauk',
        'keterangan',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'status_aktif' => 'boolean',
        ];
    }

    public function pesananPaketLauks(): HasMany
    {
        return $this->hasMany(PesananPaketLauk::class);
    }
}