<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pesanan;
use App\Models\Review;
use App\Models\Paket;
use App\Models\Lauk;
use App\Services\PesananService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Dapatkan atau buat pengguna pelanggan Budi Santoso
        $budi = User::where('email', 'budi@example.test')->first();
        if ($budi) {
            // Buat pesanan untuk Budi jika belum ada agar bisa direview
            $orderBudi = $budi->pesanans()->first();
            if (!$orderBudi) {
                $paketStandar = Paket::where('nm_paket', 'Prasmanan')->first() ?? Paket::first();
                $laukIds = Lauk::limit($paketStandar->jumlah_lauk_pilihan)->pluck('id')->toArray();
                
                if (count($laukIds) === $paketStandar->jumlah_lauk_pilihan) {
                    $orderBudi = app(PesananService::class)->store($budi, [
                        'tgl_acara' => now()->addDays(5)->toDateString(),
                        'jumlah_pax' => 50,
                        'items' => [
                            [
                                'paket_id' => $paketStandar->id,
                                'jml_paket' => 50,
                                'lauk_ids' => $laukIds,
                            ]
                        ]
                    ]);
                }
            }

            if ($orderBudi) {
                // Buat review atas nama Bambang Wijaya (kita gunakan user Budi Santoso atau buat user baru)
                Review::updateOrCreate(
                    ['pesanan_id' => $orderBudi->id],
                    [
                        'user_id' => $budi->id,
                        'rating' => 5,
                        'ulasan' => 'Sangat membantu untuk lunch meeting di kantor. Porsinya pas, packing rapi dan yang paling penting selalu on time. Tim kami sangat puas!'
                    ]
                );
            }
        }

        // 2. Buat pengguna pelanggan Anita Putri
        $anita = User::updateOrCreate(
            ['email' => 'anita@example.test'],
            [
                'name' => 'Anita Putri',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'no_telp' => '081211112222',
                'alamat' => 'Jl. Kebayoran Baru No. 12, Jakarta Selatan',
                'email_verified_at' => now(),
            ]
        );

        // Buat pesanan untuk Anita
        $orderAnita = $anita->pesanans()->first();
        if (!$orderAnita) {
            $paketPremium = Paket::where('nm_paket', 'Tumpeng')->first() ?? Paket::first();
            $laukIdsPremium = Lauk::limit($paketPremium->jumlah_lauk_pilihan)->pluck('id')->toArray();
            
            if (count($laukIdsPremium) === $paketPremium->jumlah_lauk_pilihan) {
                $orderAnita = app(PesananService::class)->store($anita, [
                    'tgl_acara' => now()->addDays(10)->toDateString(),
                    'jumlah_pax' => 100,
                    'items' => [
                        [
                            'paket_id' => $paketPremium->id,
                            'jml_paket' => 100,
                            'lauk_ids' => $laukIdsPremium,
                        ]
                    ]
                ]);
            }
        }

        if ($orderAnita) {
            Review::updateOrCreate(
                ['pesanan_id' => $orderAnita->id],
                [
                    'user_id' => $anita->id,
                    'rating' => 5,
                    'ulasan' => 'Layanan yang luar biasa! Makanan untuk pernikahan saya sangat dipuji oleh semua tamu. Rasa rendangnya juara dan presentasinya sangat elegan.'
                ]
            );
        }
    }
}
