<?php
// app/Services/PasswordService.php

namespace App\Services;

use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class PasswordService
{
    public function validatePasswordStrength(string $password): array
    {
        $errors = [];

        if (strlen($password) < 12) {
            $errors[] = 'Password must be at least 12 characters long.';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Password must contain at least one uppercase letter.';
        }

        if (!preg_match('/[a-z]/', $password)) {
            $errors[] = 'Password must contain at least one lowercase letter.';
        }

        if (!preg_match('/[0-9]/', $password)) {
            $errors[] = 'Password must contain at least one number.';
        }

        if (!preg_match('/[@$!%*?&#^()_+=\-\[\]{}|;:,.<>]/', $password)) {
            $errors[] = 'Password must contain at least one special character.';
        }

        return $errors;
    }

    public function updatePassword(Admin $admin, string $newPassword): void
    {
        $admin->update([
            'password' => Hash::make($newPassword),
            'password_changed_at' => now(),
            'password_version' => $admin->password_version + 1,
        ]);

        // Revoke all refresh tokens
        $admin->revokeAllRefreshTokens();
    }

    public function verifyPassword(Admin $admin, string $password): bool
    {
        return Hash::check($password, $admin->password);
    }
}