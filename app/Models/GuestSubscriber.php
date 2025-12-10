<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GuestSubscriber extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'email', 'verification_token', 'unsubscribe_token', 'verified_at', 'is_active'
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'is_active' => 'boolean'
    ];

    protected $hidden = ['verification_token', 'unsubscribe_token'];

    protected static function booted()
    {
        static::creating(function ($subscriber) {
            if (!$subscriber->unsubscribe_token) {
                $subscriber->unsubscribe_token = Str::random(64);
            }
        });
    }
}
