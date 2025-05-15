<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'label',
        'floor',
        'monthly_rent',
        'capacity',
        'occupancy',
        'image',
    ];

    public function leases()
    {
        return $this->hasMany(Lease::class);
    }
}
