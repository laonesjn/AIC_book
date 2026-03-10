<?php
// database/migrations/xxxx_xx_xx_create_password_resets_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('password_resets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');

            // OTP stored as bcrypt/argon2 hash — raw OTP is never persisted
            $table->string('otp_hash');

            // Verification token stored as SHA-256 hash — raw token in httpOnly cookie only
            $table->string('verification_token_hash', 64)->nullable();

            $table->timestamp('expires_at');
            $table->boolean('used')->default(false);
            $table->timestamps();

            $table->index(['admin_id', 'used', 'expires_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('password_resets');
    }
};