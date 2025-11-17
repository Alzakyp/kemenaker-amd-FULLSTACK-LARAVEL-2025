<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'code',
        'name',
        'type',
        'age',
        'weight',
        'raw_input',
    ];

    protected $casts = [
        'age'    => 'integer',
        'weight' => 'decimal:2',
    ];

    /**
     * Hewan dimiliki oleh satu owner.
     */
    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * Hewan punya banyak pemeriksaan.
     */
    public function checkups()
    {
        return $this->hasMany(Checkup::class);
    }
}
