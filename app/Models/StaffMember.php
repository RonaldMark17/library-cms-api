<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'role', 'email', 'phone', 'image_path', 'bio', 'order', 'is_active'
    ];

    protected $casts = [
        'name' => 'array',
        'role' => 'array',
        'bio' => 'array',
        'is_active' => 'boolean'
    ];
}