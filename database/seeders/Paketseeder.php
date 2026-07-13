<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        Paket::create([
            'nm_paket' => 'Paket Hemat',
            'harga_paket' => 35000,
            'jumlah_lauk_pilihan' => 3,
            'deskripsi' => 'Paket ekonomis, pilih 3 dari 10 lauk.',
            'status_aktif' => true,
        ]);

        Paket::create([
            'nm_paket' => 'Paket Standar',
            'harga_paket' => 50000,
            'jumlah_lauk_pilihan' => 5,
            'deskripsi' => 'Paket favorit, pilih 5 dari 10 lauk.',
            'status_aktif' => true,
        ]);

        Paket::create([
            'nm_paket' => 'Paket Premium',
            'harga_paket' => 75000,
            'jumlah_lauk_pilihan' => 7,
            'deskripsi' => 'Paket lengkap, pilih 7 dari 10 lauk.',
            'status_aktif' => true,
        ]);
    }
}