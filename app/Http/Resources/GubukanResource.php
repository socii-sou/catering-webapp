<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GubukanResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_gubukan' => $this->nama_gubukan,
            'harga_gubukan' => (float) $this->harga_gubukan,
            'kapasitas_orang' => $this->kapasitas_orang,
            'status_aktif' => $this->status_aktif,
        ];
    }
}