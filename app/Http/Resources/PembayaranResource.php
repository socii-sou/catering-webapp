<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tgl_bayar' => $this->tgl_bayar,
            'jml_bayar' => (float) $this->jml_bayar,
            'metode_bayar' => $this->metode_bayar,
            'status_bayar' => $this->status_bayar,
            'bukti_bayar' => $this->bukti_bayar,
        ];
    }
}