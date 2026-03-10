<?php
// database/migrations/xxxx_xx_xx_create_refresh_tokens_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('refresh_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->uuid('jti')->unique();

            // Stored as SHA-256 hash — raw token is never persisted
            $table->string('token_hash', 64)->unique();

            $table->timestamp('expires_at');
            $table->boolean('revoked')->default(false);
            $table->timestamps();

            // Composite index for the primary lookup query:
            // WHERE token_hash = ? AND revoked = 0 AND expires_at > NOW()
            $table->index(['token_hash', 'revoked', 'expires_at']);

            // For per-admin device cap queries
            $table->index(['admin_id', 'revoked', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('refresh_tokens');
    }
};