<?php

namespace Database\Seeders;

use App\Models\Gubukan;
use Illuminate\Database\Seeder;

class GubukanSeeder extends Seeder
{
    public function run(): void
    {
        Gubukan::create([
            'nama_gubukan' => 'Gubukan Kecil',
            'harga_gubukan' => 150000,
            'kapasitas_orang' => 10,
            'status_aktif' => true,
        ]);

        Gubukan::create([
            'nama_gubukan' => 'Gubukan Sedang',
            'harga_gubukan' => 250000,
            'kapasitas_orang' => 25,
            'status_aktif' => true,
        ]);

        Gubukan::create([
            'nama_gubukan' => 'Gubukan Besar',
            'harga_gubukan' => 400000,
            'kapasitas_orang' => 50,
            'status_aktif' => true,
        ]);
    }
}   