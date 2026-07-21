<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PesananResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nama_acara' => $this->nama_acara,
            'tipe_acara' => $this->tipe_acara,
            'alamat_pengiriman' => $this->alamat_pengiriman,
            'tgl_pesan' => $this->tgl_pesan,
            'tgl_acara' => $this->tgl_acara,
            'jumlah_pax' => $this->jumlah_pax,
            'status_pesanan' => $this->status_pesanan,
            'status_produksi' => $this->status_produksi,
            'catatan' => $this->catatan,
            'subtotal' => (float) $this->total_harga,
            'biaya_pengiriman' => (float) $this->biaya_pengiriman,
            'total_keseluruhan' => (float) $this->total_harga + (float) $this->biaya_pengiriman,

            // Relasi ini cuma muncul di response kalau memang di-eager-load
            // duluan di controller (pakai ->with([...]) atau ->load([...])).
            // Kalau tidak di-load, field ini otomatis hilang dari JSON,
            // bukan malah bikin query N+1 tambahan.
            'pelanggan' => new UserResource($this->whenLoaded('user')),
            'gubukan' => new GubukanResource($this->whenLoaded('gubukan')),
            'paket_dipesan' => PesananPaketResource::collection($this->whenLoaded('pesananPaket')),
            'pembayaran' => PembayaranResource::collection($this->whenLoaded('pembayarans')),
            'pengiriman' => new PengirimanResource($this->whenLoaded('pengiriman')),
            'review' => new ReviewResource($this->whenLoaded('review')),

            'created_at' => $this->created_at,
        ];
    }
}