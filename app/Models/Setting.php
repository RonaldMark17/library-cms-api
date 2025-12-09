<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    public function getValueAttribute($value)
    {
        return match($this->type) {
            'boolean' => (bool) $value,
            'json' => json_decode($value, true),
            'integer' => (int) $value,
            default => $value
        };
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = match($this->type) {
            'boolean' => $value ? '1' : '0',
            'json' => json_encode($value),
            default => $value
        };
    }
}