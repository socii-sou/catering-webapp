<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengirimanResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'waktu_berangkat' => $this->waktu_berangkat,
            'waktu_tiba' => $this->waktu_tiba,
            'status_pengiriman' => $this->status_pengiriman,
            'alamat_tujuan' => $this->alamat_tujuan,
        ];
    }
}