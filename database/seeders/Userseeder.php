<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Akun Penjual
        User::firstOrCreate(
            ['email' => 'penjual@catering.test'],
            [
                'name' => 'Admin Penjual',
                'password' => Hash::make('password'),
                'role' => 'penjual',
                'no_telp' => '081234567890',
                'email_verified_at' => now(),
            ]
        );

        // Akun Pelanggan
        User::firstOrCreate(
            ['email' => 'budi@example.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'pelanggan',
                'no_telp' => '081298765432',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'email_verified_at' => now(),
            ]
        );

        // Tambahan pelanggan dummy
        if (User::where('role', 'pelanggan')->count() < 5) {
            User::factory()->count(5)->pelanggan()->create();
        }
    }
}