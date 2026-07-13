<?php

namespace App\Policies;

use App\Models\Pesanan;
use App\Models\User;

class PesananPolicy
{
    public function view(User $user, Pesanan $pesanan): bool
    {
        return $user->isPenjual() || $user->id === $pesanan->user_id;
    }

    public function create(User $user): bool
    {
        return $user->isPelanggan();
    }
    public function updateStatus(User $user, Pesanan $pesanan): bool
    {
        return $user->isPenjual();
    }

    public function review(User $user, Pesanan $pesanan): bool
    {
        return $user->id === $pesanan->user_id
            && $pesanan->status_pesanan === 'selesai';
    }
}