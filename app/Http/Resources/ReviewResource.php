<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'rating' => $this->rating,
            'ulasan' => $this->ulasan,
            'pelanggan' => new UserResource($this->whenLoaded('user')),
            'created_at' => $this->created_at,
        ];
    }
}