<?php
// database/migrations/xxxx_xx_xx_create_blacklisted_tokens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blacklisted_tokens', function (Blueprint $table) {
            $table->id();
            // UUID jti from JWT — 36 chars
            $table->string('jti', 36)->unique();
            // Token is only useful in this table until it naturally expires.
            // The PruneExpiredTokens command cleans rows where expires_at < NOW().
            $table->timestamp('expires_at');
            $table->timestamps();

            // Critical: this index powers every authenticated request's blacklist check
            $table->index(['jti', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blacklisted_tokens');
    }
};