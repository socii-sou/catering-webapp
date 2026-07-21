<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaketResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nm_paket' => $this->nm_paket,
            'kategori_produk' => $this->when(
                $this->relationLoaded('kategoriProduk') && $this->kategoriProduk,
                fn () => [
                    'id' => $this->kategoriProduk->id,
                    'nama_kategori' => $this->kategoriProduk->nama_kategori,
                    'slug' => $this->kategoriProduk->slug,
                    'mendukung_gubukan' => $this->kategoriProduk->mendukung_gubukan,
                ]
            ),
            'harga_paket' => (float) $this->harga_paket,
            'jumlah_lauk_pilihan' => $this->jumlah_lauk_pilihan,
            'deskripsi' => $this->deskripsi,
            'status_aktif' => $this->status_aktif,

            'kuota_per_kategori' => $this->when(
                $this->relationLoaded('kategoriKuota'),
                fn () => $this->kategoriKuota->map(fn ($kuota) => [
                    'kategori_lauk_id' => $kuota->kategori_lauk_id,
                    'nama_kategori' => $kuota->kategoriLauk->nama_kategori ?? null,
                    'jumlah_pilihan' => $kuota->jumlah_pilihan,
                ])
            ),
        ];
    }
}