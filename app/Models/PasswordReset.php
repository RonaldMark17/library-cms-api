<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    
    // Disable timestamps because the table only has created_at, no updated_at
    public $timestamps = false;

    protected $fillable = [
        'email',
        'token',
        'created_at'
    ];
}
