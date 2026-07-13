<?php

namespace Database\Seeders;

use App\Models\CapacitySetting;
use Illuminate\Database\Seeder;

class CapacitySeeder extends Seeder
{
    public function run(): void
    {
        CapacitySetting::create([
            'tanggal' => null,
            'kapasitas_maks_pax' => 500,
        ]);
    }
}