<?php
// app/Models/PasswordReset.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $fillable = [
        'admin_id',
        'otp_hash',
        'verification_token_hash',
        'expires_at',
        'used',
    ];

    protected $hidden = [
        'otp_hash',                  // Never expose stored hashes
        'verification_token_hash',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used'       => 'boolean',
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
        return !$this->used && !$this->isExpired();
    }
}