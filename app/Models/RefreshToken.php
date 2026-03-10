<?php
// app/Models/RefreshToken.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RefreshToken extends Model
{
    protected $fillable = [
        'admin_id',
        'jti',
        'token_hash',
        'expires_at',
        'revoked',
    ];

    protected $hidden = [
        'token_hash', // Never expose the stored hash
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'revoked'    => 'boolean',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function isExpired(): bool
    {
        return now()->greaterThan($this->expires_at);
    }

    public function isValid(): bool
    {
        return !$this->revoked && !$this->isExpired();
    }
}