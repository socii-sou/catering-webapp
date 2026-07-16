<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesananPaketResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'jml_paket' => $this->jml_paket,
            'paket' => new PaketResource($this->whenLoaded('paket')),
            // relasi "lauks" isinya baris pesanan_paket_lauk, tiap barisnya
            // punya relasi "lauk" ke data master lauk -> kita ambil lauk-nya saja.
            'lauk_dipilih' => $this->when(
                $this->relationLoaded('lauks'),
                fn () => LaukResource::collection($this->lauks->pluck('lauk'))
            ),
        ];
    }
}