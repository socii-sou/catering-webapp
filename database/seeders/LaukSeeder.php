<?php

namespace Database\Seeders;

use App\Models\Lauk;
use Illuminate\Database\Seeder;

class LaukSeeder extends Seeder
{
    public function run(): void
    {
        $lauks = [
            'Ayam Goreng',
            'Ayam Bakar',
            'Rendang Sapi',
            'Sate Ayam',
            'Ikan Bakar',
            'Ikan Goreng',
            'Udang Balado',
            'Cumi Saus Padang',
            'Telur Balado',
            'Tahu Tempe Bacem',
        ];

        foreach ($lauks as $nama) {
            Lauk::firstOrCreate(
                ['nama_lauk' => $nama],
                ['status_aktif' => true]
            );
        }
    }
}