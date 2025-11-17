<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'treatment_id',
        'checkup_date',
        'weight_at_checkup',
        'notes',
    ];

    protected $casts = [
        'checkup_date'      => 'date',
        'weight_at_checkup' => 'decimal:2',
    ];

    /**
     * Pemeriksaan milik satu hewan.
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Pemeriksaan menggunakan satu treatment.
     */
    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }
}
