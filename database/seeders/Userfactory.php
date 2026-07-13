<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Password yang sama dipakai berulang (di-cache) supaya generate ribuan user tetap cepat.
     */
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => 'pelanggan',
            'no_telp' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'remember_token' => Str::random(10),
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function penjual(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'penjual',
        ]);
    }

    public function pelanggan(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pelanggan',
        ]);
    }
}