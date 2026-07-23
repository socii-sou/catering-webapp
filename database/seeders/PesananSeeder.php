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
        $paket = Paket::first();

        if (! $pelanggan || ! $paket) {
            return;
        }

        $limitLauk = $paket->jumlah_lauk_pilihan > 0 ? $paket->jumlah_lauk_pilihan : 3;
        $laukIds = Lauk::inRandomOrder()->limit($limitLauk)->pluck('id')->toArray();

        if (empty($laukIds)) {
            return;
        }

        app(PesananService::class)->store($pelanggan, [
            'nama_acara' => 'Meeting Kantor Bulanan',
            'tipe_acara' => 'Rapat Kantor',
            'alamat_pengiriman' => 'Jl. Sudirman No. 45, Jakarta Selatan',
            'tgl_acara' => now()->addDays(7)->toDateString(),
            'jumlah_pax' => 50,
            'catatan' => 'Pesanan contoh dari seeder untuk testing.',
            'items' => [
                [
                    'paket_id' => $paket->id,
                    'jml_paket' => 50,
                    'lauk_ids' => $laukIds,
                ],
            ],
        ]);
    }
}