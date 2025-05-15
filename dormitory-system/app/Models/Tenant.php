<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Tenant extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'username', 'password', 'room_id'];
 
    public function lease()
    {
        return $this->hasOne(Lease::class);
    }
}
