<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'no_telp',
        'alamat',
        'google_id',
        'avatar',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /*
    |--------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------
    */

    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /*
    |--------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------
    */

    public function isPenjual(): bool
    {
        return $this->role === 'penjual';
    }

    public function isPelanggan(): bool
    {
        return $this->role === 'pelanggan';
    }

    public function getAvatarUrlAttribute(): string
    {
        if (empty($this->avatar)) {
            return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=2D5A27&color=ffffff&bold=true';
        }

        if (str_starts_with($this->avatar, 'http://') || str_starts_with($this->avatar, 'https://')) {
            return $this->avatar;
        }

        return asset('storage/' . $this->avatar);
    }
}