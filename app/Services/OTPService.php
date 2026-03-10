<?php
// app/Services/OTPService.php

namespace App\Services;

use App\Models\Admin;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class OTPService
{
    public function generateOTP(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function generateVerificationToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function createPasswordReset(Admin $admin, string $otp, ?string $verificationToken = null): PasswordReset
    {
        // Invalidate old resets
        PasswordReset::where('admin_id', $admin->id)
            ->where('used', false)
            ->update(['used' => true]);

        return PasswordReset::create([
            'admin_id' => $admin->id,
            'otp_hash' => hash('sha256', $otp),
            'verification_token_hash' => $verificationToken ? hash('sha256', $verificationToken) : null,
            'expires_at' => now()->addMinutes(5),
            'used' => false,
        ]);
    }

    public function verifyOTP(Admin $admin, string $otp): ?PasswordReset
    {
        $otpHash = hash('sha256', $otp);

        $reset = PasswordReset::where('admin_id', $admin->id)
            ->where('otp_hash', $otpHash)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();

        return $reset;
    }

    public function verifyToken(Admin $admin, string $token): ?PasswordReset
    {
        $tokenHash = hash('sha256', $token);

        return PasswordReset::where('admin_id', $admin->id)
            ->where('verification_token_hash', $tokenHash)
            ->where('used', false)
            ->where('expires_at', '>', now())
            ->first();
    }

    public function markAsUsed(PasswordReset $reset): void
    {
        $reset->update(['used' => true]);
    }
}