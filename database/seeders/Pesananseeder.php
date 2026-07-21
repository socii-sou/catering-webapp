<?php

namespace Database\Seeders;

use App\Models\Lauk;
use App\Models\Paket;
use App\Models\User;
use App\Services\PesananService;
use Illuminate\Database\Seeder;

class PesananSeeder extends Seeder
{
    public function run(): void
    {
        $pelanggan = User::where('email', 'budi@example.test')->first();
        $paketStandar = Paket::where('nm_paket', 'Paket Standar')->first();

        if (! $pelanggan || ! $paketStandar) {
            return; // jalankan UserSeeder & PaketSeeder dulu
        }

        $laukIds = Lauk::inRandomOrder()->limit($paketStandar->jumlah_lauk_pilihan)->pluck('id')->toArray();

        if (count($laukIds) < $paketStandar->jumlah_lauk_pilihan) {
            return; // jalankan LaukSeeder dulu
        }

        // Sengaja pakai PesananService (bukan Pesanan::create langsung) supaya
        // data contoh ini melewati validasi kapasitas & perhitungan total harga
        // yang sama persis dengan yang dipakai controller asli.
        //
        // Catatan: TIDAK menyertakan gubukan_id di sini, karena "Paket Standar"
        // dari PaketSeeder generik belum dikaitkan ke kategori produk manapun
        // (kategori_produk_id masih NULL) -- jadi otomatis dianggap tidak
        // mendukung gubukan. Kalau mau contoh pesanan dengan gubukan, jalankan
        // PrasmananSeeder dulu lalu pakai salah satu paket dari situ.
        app(PesananService::class)->store($pelanggan, [
            'nama_acara' => 'Meeting Kantor Bulanan',
            'tipe_acara' => 'Rapat Kantor',
            'alamat_pengiriman' => 'Jl. Sudirman No. 45, Jakarta Selatan',
            'tgl_acara' => now()->addDays(7)->toDateString(),
            'jumlah_pax' => 50,
            'catatan' => 'Pesanan contoh dari seeder untuk testing.',
            'items' => [
                [
                    'paket_id' => $paketStandar->id,
                    'jml_paket' => 50,
                    'lauk_ids' => $laukIds,
                ],
            ],
        ]);
    }
}