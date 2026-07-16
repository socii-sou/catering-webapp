<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LaukResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_lauk' => $this->nama_lauk,
            'keterangan' => $this->keterangan,
            'status_aktif' => $this->status_aktif,
        ];
    }
}