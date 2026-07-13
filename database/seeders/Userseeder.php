<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Penjual (login untuk manajemen paket, validasi, laporan)
        User::create([
            'name' => 'Admin Penjual',
            'email' => 'penjual@catering.test',
            'password' => Hash::make('password'),
            'role' => 'penjual',
            'no_telp' => '081234567890',
            'email_verified_at' => now(),
        ]);

        // Akun Pelanggan contoh yang gampang diingat untuk testing manual
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.test',
            'password' => Hash::make('password'),
            'role' => 'pelanggan',
            'no_telp' => '081298765432',
            'alamat' => 'Jl. Merdeka No. 10, Jakarta',
            'email_verified_at' => now(),
        ]);

        // Tambahan 8 pelanggan dummy random pakai factory
        User::factory()->count(8)->pelanggan()->create();
    }
}