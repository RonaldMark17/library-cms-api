<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, SoftDeletes;

    protected $fillable = [
    'name',
    'email',
    'password',
    'role',
    'disabled',
    'two_factor_enabled', // <-- add this
    'phone',
    'image_path',
    'bio',
    'order',
    'is_active',
];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'disabled' => 'boolean',
        'is_active' => 'boolean',
        'bio' => 'array',
    ];

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isLibrarian()
    {
        return in_array($this->role, ['admin', 'librarian']);
    }
}
