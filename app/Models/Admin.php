<?php
// app/Models/Admin.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'permissions',
        'password_changed_at',
        'password_expires_at',
        'password_version',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'password_version', // Never expose version number to API responses
        'password_changed_at',
        'password_expires_at',
    ];

    protected $casts = [
        'permissions'          => 'array',
        'password_changed_at'  => 'datetime',
        'password_expires_at'  => 'datetime',
        'last_login_at'        => 'datetime',
        'is_active'            => 'boolean',
        'password_version'     => 'integer',
    ];

    public function refreshTokens()
    {
        return $this->hasMany(RefreshToken::class);
    }

    public function passwordResets()
    {
        return $this->hasMany(PasswordReset::class);
    }

    public function isPasswordExpired(): bool
    {
        return false;
    }

    /**
     * Revoke all active refresh tokens.
     * Called on password change and password reset to force re-login on all devices.
     */
    public function revokeAllRefreshTokens(): void
    {
        $this->refreshTokens()->where('revoked', false)->update(['revoked' => true]);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return is_array($this->permissions) && in_array($permission, $this->permissions);
    }
}