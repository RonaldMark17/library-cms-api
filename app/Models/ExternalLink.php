<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExternalLink extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'url', 'description', 'icon', 'order', 'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean'
    ];
}
