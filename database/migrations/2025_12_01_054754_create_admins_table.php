<?php
// database/migrations/xxxx_xx_xx_create_admins_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email', 254)->unique();
            $table->string('password');
            $table->string('role', 50)->default('admin');

            // Password lifecycle
            $table->timestamp('password_changed_at')->nullable();
            $table->timestamp('password_expires_at')->nullable();
            // Incremented on every password change — invalidates all issued JWTs
            $table->unsignedSmallInteger('password_version')->default(1);

            $table->boolean('is_active')->default(true);

            // Audit (no raw IP stored — privacy-conscious; only last login time)
            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('email');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};