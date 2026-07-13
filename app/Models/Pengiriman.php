<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengiriman extends Model
{
    use HasFactory;

    protected $fillable = [
        'pesanan_id',
        'waktu_berangkat',
        'waktu_tiba',
        'status_pengiriman',
        'alamat_tujuan',
    ];

    protected function casts(): array
    {
        return [
            'waktu_berangkat' => 'datetime',
            'waktu_tiba' => 'datetime',
        ];
    }


    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class);
    }
}