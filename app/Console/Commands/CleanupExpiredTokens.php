<?php
// app/Console/Commands/CleanupExpiredTokens.php

namespace App\Console\Commands;

use App\Models\BlacklistedToken;
use App\Models\PasswordReset;
use App\Models\RefreshToken;
use Illuminate\Console\Command;

class CleanupExpiredTokens extends Command
{
    protected $signature = 'tokens:cleanup';
    protected $description = 'Cleanup expired tokens and password resets';

    public function handle()
    {
        $this->info('Cleaning up expired tokens...');

        // Cleanup expired blacklisted tokens
        $blacklistedCount = BlacklistedToken::where('expires_at', '<', now())->delete();
        $this->info("Deleted {$blacklistedCount} expired blacklisted tokens");

        // Cleanup expired refresh tokens
        $refreshCount = RefreshToken::where('expires_at', '<', now())->delete();
        $this->info("Deleted {$refreshCount} expired refresh tokens");

        // Cleanup old password resets
        $resetCount = PasswordReset::where('expires_at', '<', now()->subDays(7))->delete();
        $this->info("Deleted {$resetCount} old password resets");

        $this->info('Cleanup completed successfully!');
        
        return 0;
    }
}