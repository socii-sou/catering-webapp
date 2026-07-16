<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            Userseeder::class,             // akun penjual & pelanggan dulu
            Laukseeder::class,             // master lauk
            Paketseeder::class,            // master paket (butuh angka jumlah_lauk_pilihan)
            Gubukanseeder::class,          // master gubukan
            Capacityseeder::class,  // pengaturan kapasitas
            Pesananseeder::class,          // contoh transaksi, butuh semua di atas sudah ada
            ReviewSeeder::class,           // review/ulasan pelanggan
        ]);
    }
}