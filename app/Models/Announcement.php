<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title',
        'content',
        'image_path',
        'priority',
        'active',
        'published_at',
        'expires_at',
        'created_by',
        'notified_at'
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'published_at' => 'datetime',
        'expires_at' => 'datetime',
        'active' => 'boolean',
        'notified_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function getTitleForLang(string $lang = 'en'): string
    {
        return $this->title[$lang] ?? $this->title['en'] ?? '';
    }

    public function getContentForLang(string $lang = 'en'): string
    {
        return $this->content[$lang] ?? $this->content['en'] ?? '';
    }
}
