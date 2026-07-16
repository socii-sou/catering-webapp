<?php

namespace Database\Seeders;

use App\Models\Gubukan;
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
        $paketStandar = Paket::where('nm_paket', 'Prasmanan')->first();
        $gubukan = Gubukan::first();

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
        app(PesananService::class)->store($pelanggan, [
            'gubukan_id' => $gubukan?->id,
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