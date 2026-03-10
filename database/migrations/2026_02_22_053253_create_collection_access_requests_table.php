<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('collection_access_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('collection_id')->constrained('collections')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('full_phone')->nullable();
            $table->string('country_name')->nullable();
            $table->text('why');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_access_requests');
    }
};
