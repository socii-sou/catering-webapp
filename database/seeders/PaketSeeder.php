<?php

namespace Database\Seeders;

use App\Models\Paket;
use Illuminate\Database\Seeder;

class PaketSeeder extends Seeder
{
    public function run(): void
    {
        $pakets = [
            [
                'nm_paket' => 'Nasi Kotak',
                'harga_paket' => 35000,
                'jumlah_lauk_pilihan' => 3,
                'deskripsi' => 'Solusi praktis untuk rapat kantor, seminar, atau konsumsi panitia dengan cita rasa Nusantara yang konsisten dan higienis.',
                'status_aktif' => true,
            ],
            [
                'nm_paket' => 'Prasmanan',
                'harga_paket' => 65000,
                'jumlah_lauk_pilihan' => 5,
                'deskripsi' => 'Pilihan tepat untuk pesta pernikahan, reuni, atau acara besar keluarga dengan variasi menu terlengkap.',
                'status_aktif' => true,
            ],
            [
                'nm_paket' => 'Tumpeng',
                'harga_paket' => 500000,
                'jumlah_lauk_pilihan' => 5,
                'deskripsi' => 'Sajian khas untuk syukuran, peresmian, dan momen berharga Anda.',
                'status_aktif' => true,
            ],
        ];

        foreach ($pakets as $p) {
            Paket::updateOrCreate(
                ['nm_paket' => $p['nm_paket']],
                $p
            );
        }
    }
}
