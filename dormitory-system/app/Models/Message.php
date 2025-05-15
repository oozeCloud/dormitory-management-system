<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'content',
    ];

    public function sender()
    {
        return $this->belongsTo(Tenant::class, 'sender_id');
    }
}