<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CapacitySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'kapasitas_maks_pax',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'kapasitas_maks_pax' => 'integer',
        ];
    }
}