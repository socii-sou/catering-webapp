<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gubukan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_gubukan',
        'harga_gubukan',
        'kapasitas_orang',
        'status_aktif',
    ];

    protected function casts(): array
    {
        return [
            'harga_gubukan' => 'decimal:2',
            'kapasitas_orang' => 'integer',
            'status_aktif' => 'boolean',
        ];
    }

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }
}