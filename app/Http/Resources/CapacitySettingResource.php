<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CapacitySettingResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'tanggal' => $this->tanggal,
            'kapasitas_maks_pax' => $this->kapasitas_maks_pax,
            'keterangan' => $this->tanggal === null ? 'Default global (berlaku untuk semua tanggal lain)' : null,
        ];
    }
}