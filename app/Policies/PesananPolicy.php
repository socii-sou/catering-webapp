<?php

namespace App\Policies;

use App\Models\Pesanan;
use App\Models\User;

class PesananPolicy
{
    /**
     * Pelanggan hanya boleh lihat pesanan miliknya sendiri.
     * Penjual boleh lihat semua pesanan (untuk validasi & manajemen).
     */
    public function view(User $user, Pesanan $pesanan): bool
    {
        return $user->isPenjual() || $user->id === $pesanan->user_id;
    }

    /**
     * Hanya pelanggan yang boleh membuat pesanan baru.
     */
    public function create(User $user): bool
    {
        return $user->isPelanggan();
    }

    /**
     * Hanya Penjual yang boleh mengubah status_pesanan / status_produksi
     * (validasi & status produksi). Pengecualian: transisi ke "selesai"
     * itu wewenang Pelanggan sendiri lewat method confirmSelesai() di bawah.
     */
    public function updateStatus(User $user, Pesanan $pesanan): bool
    {
        return $user->isPenjual();
    }

    /**
     * Pelanggan (pemilik pesanan) boleh konfirmasi pesanan sudah diterima,
     * TAPI hanya kalau statusnya sedang "disetujui" -- tidak bisa konfirmasi
     * pesanan yang masih menunggu validasi, ditolak, atau sudah dibatalkan.
     */
    public function confirmSelesai(User $user, Pesanan $pesanan): bool
    {
        return $user->id === $pesanan->user_id
            && $pesanan->status_pesanan === 'disetujui';
    }

    /**
     * Pelanggan cuma boleh kasih review untuk pesanan miliknya sendiri,
     * dan hanya kalau pesanan itu sudah "selesai".
     */
    public function review(User $user, Pesanan $pesanan): bool
    {
        return $user->id === $pesanan->user_id
            && $pesanan->status_pesanan === 'selesai';
    }
}