<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        Paket::create([
            'nm_paket' => 'Nasi Kotak',
            'harga_paket' => 35000,
            'jumlah_lauk_pilihan' => 3,
            'deskripsi' => 'Solusi praktis untuk rapat kantor, seminar, atau konsumsi panitia dengan cita rasa Nusantara yang konsisten.',
            'status_aktif' => true,
        ]);

        Paket::create([
            'nm_paket' => 'Prasmanan',
            'harga_paket' => 50000,
            'jumlah_lauk_pilihan' => 5,
            'deskripsi' => 'Pilihan ideal untuk perhelatan besar seperti pernikahan, khitanan, atau gathering tahunan perusahaan dengan menu lengkap.',
            'status_aktif' => true,
        ]);

        Paket::create([
            'nm_paket' => 'Tumpeng',
            'harga_paket' => 75000,
            'jumlah_lauk_pilihan' => 7,
            'deskripsi' => 'Sajian ikonik untuk momen sakral seperti peresmian kantor, syukuran rumah, atau ulang tahun instansi.',
            'status_aktif' => true,
        ]);
    }
}