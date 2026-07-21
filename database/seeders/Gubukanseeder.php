<?php

namespace Database\Seeders;

use App\Models\Gubukan;
use Illuminate\Database\Seeder;

class GubukanSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['nama_gubukan' => 'Bakso', 'harga_gubukan' => 15000, 'kapasitas_orang' => 50, 'status_aktif' => true],
            ['nama_gubukan' => 'Batagor', 'harga_gubukan' => 15000, 'kapasitas_orang' => 50, 'status_aktif' => true],
            ['nama_gubukan' => 'Empek-empek', 'harga_gubukan' => 18000, 'kapasitas_orang' => 50, 'status_aktif' => true],
            ['nama_gubukan' => 'Zuppa Soup', 'harga_gubukan' => 20000, 'kapasitas_orang' => 50, 'status_aktif' => true],
            ['nama_gubukan' => 'Dimsum', 'harga_gubukan' => 15000, 'kapasitas_orang' => 50, 'status_aktif' => true],
        ];

        foreach ($items as $item) {
            Gubukan::updateOrCreate(
                ['nama_gubukan' => $item['nama_gubukan']],
                $item
            );
        }
    }
}   