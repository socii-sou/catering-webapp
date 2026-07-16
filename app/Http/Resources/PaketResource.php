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
            'harga_paket' => (float) $this->harga_paket,
            'jumlah_lauk_pilihan' => $this->jumlah_lauk_pilihan,
            'deskripsi' => $this->deskripsi,
            'status_aktif' => $this->status_aktif,
        ];
    }
}