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
        "name",
        "email",
        "password",
        "role",
        "disabled",
        "two_factor_enabled",
        "two_factor_secret",
        "two_factor_recovery_codes",
    ];

    protected $hidden = [
        "password",
        "remember_token",
        "two_factor_secret",
        "two_factor_recovery_codes",
    ];

    protected $casts = [
        "email_verified_at" => "datetime",
        "two_factor_enabled" => "boolean",
        "two_factor_recovery_codes" => "array",
        "disabled" => "boolean",
    ];

    public function announcements()
    {
        return $this->hasMany(Announcement::class, "created_by");
    }

    public function isAdmin()
    {
        return $this->role === "admin";
    }

    public function isLibrarian()
    {
        return in_array($this->role, ["admin", "librarian"]);
    }
}
