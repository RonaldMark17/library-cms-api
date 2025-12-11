<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GuestSubscriber extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email', 'verification_token', 'verified_at', 'is_active','unsubscribe_token'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    protected $hidden = ['verification_token'];
}