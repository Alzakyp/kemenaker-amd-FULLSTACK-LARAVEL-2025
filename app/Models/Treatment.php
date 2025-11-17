<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treatment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    protected $casts = [
        'price' => 'integer', // kalau di DB pakai unsignedInteger
        // kalau pakai decimal di DB, bisa pakai 'decimal:2'
    ];

    /**
     * Satu treatment bisa dipakai di banyak pemeriksaan.
     */
    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }
}
