<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentSection extends Model
{
    use SoftDeletes;

    protected $fillable = ['key', 'content', 'order', 'is_active'];

    protected $casts = [
        'content' => 'array',
        'is_active' => 'boolean'
    ];
}