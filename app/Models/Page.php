<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'title', 'content', 'meta_description', 'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'is_active' => 'boolean'
    ];
}