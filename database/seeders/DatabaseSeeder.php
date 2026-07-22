<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,             // akun penjual & pelanggan dulu
            LaukSeeder::class,             // master lauk
            PaketSeeder::class,            // master paket
            GubukanSeeder::class,          // master gubukan
            CapacitySeeder::class,         // pengaturan kapasitas
            PesananSeeder::class,          // contoh transaksi
            ReviewSeeder::class,           // review/ulasan pelanggan
        ]);
    }
}