<?php
// app/Models/BlacklistedToken.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlacklistedToken extends Model
{
    protected $fillable = [
        'jti',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check whether a JTI is currently blacklisted.
     *
     * SECURITY: The expires_at guard ensures we don't treat a stale row as active
     * after the cleanup command has been delayed. Even without cleanup running,
     * an expired token would be rejected by JWT decode before reaching this check.
     */
    public static function isBlacklisted(string $jti): bool
    {
        return self::where('jti', $jti)
            ->where('expires_at', '>', now())
            ->exists();
    }
}