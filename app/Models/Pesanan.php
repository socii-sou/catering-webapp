<?php

namespace App\Models;

use App\Observers\PesananObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy(PesananObserver::class)]
class Pesanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_acara',
        'tipe_acara',
        'alamat_pengiriman',
        'gubukan_id',
        'tgl_pesan',
        'tgl_acara',
        'jumlah_pax',
        'jumlah_pax_gubukan',
        'status_pesanan',
        'status_produksi',
        'catatan',
        'biaya_pengiriman',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'tgl_pesan' => 'date',
            'tgl_acara' => 'date',
            'jumlah_pax' => 'integer',
            'jumlah_pax_gubukan' => 'integer',
            'biaya_pengiriman' => 'decimal:2',
            'total_harga' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gubukan(): BelongsTo
    {
        return $this->belongsTo(Gubukan::class);
    }

    public function pesananPaket(): HasMany
    {
        return $this->hasMany(PesananPaket::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function pengiriman(): HasOne
    {
        return $this->hasOne(Pengiriman::class);
    }

    public function review(): HasOne
    {
        return $this->hasOne(Review::class);
    }

    /*
    |--------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------
    */

    /**
     * Total yang sudah benar-benar terbayar (cuma hitung pembayaran yang
     * statusnya sudah lunas, DP maupun pelunasan digabung).
     */
    public function totalDibayar(): float
    {
        return (float) $this->pembayarans()->where('status_bayar', 'lunas')->sum('jml_bayar');
    }

    /**
     * Sisa yang masih perlu dibayar sampai pesanan ini lunas total.
     */
    public function sisaTagihan(): float
    {
        $totalKeseluruhan = (float) $this->total_harga + (float) $this->biaya_pengiriman;

        return max($totalKeseluruhan - $this->totalDibayar(), 0);
    }
}