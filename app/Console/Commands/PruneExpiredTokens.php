<?php
// app/Console/Commands/PruneExpiredTokens.php

namespace App\Console\Commands;

use App\Models\BlacklistedToken;
use App\Models\RefreshToken;
use Illuminate\Console\Command;

class PruneExpiredTokens extends Command
{
    protected $signature   = 'auth:prune-tokens';
    protected $description = 'Delete expired blacklisted tokens and expired refresh tokens to prevent unbounded table growth.';

    public function handle(): int
    {
        // SECURITY FIX: Blacklist table grows forever without this cleanup.
        // Tokens are only useful in the blacklist until they naturally expire.
        // After expiry they can never be replayed, so removal is safe.
        $blacklisted = BlacklistedToken::where('expires_at', '<', now())->delete();
        $this->info("Pruned {$blacklisted} expired blacklisted token(s).");

        // Also prune old revoked/expired refresh tokens
        $refreshDeleted = RefreshToken::where(function ($q) {
            $q->where('expires_at', '<', now())
              ->orWhere('revoked', true);
        })
        ->where('created_at', '<', now()->subDays(31)) // keep recent revoked for audit trail
        ->delete();

        $this->info("Pruned {$refreshDeleted} stale refresh token(s).");

        return self::SUCCESS;
    }
}