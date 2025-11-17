<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'is_phone_verified',
        'phone_verified_at',
        'address',
    ];

    protected $casts = [
        'is_phone_verified' => 'boolean',
        'phone_verified_at' => 'datetime',
    ];

    /**
     * Owner punya banyak hewan.
     */
    public function pets()
    {
        return $this->hasMany(Pet::class);
    }

    /**
     * Scope untuk hanya owner yang nomor HP-nya sudah terverifikasi.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_phone_verified', true);
    }
}
