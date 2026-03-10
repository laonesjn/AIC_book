<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artifacts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exhibition_id')->constrained('exhibitions')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->string('file_location')->nullable(); // Physical location of artifact e.g. "Room A, Case 3"
            $table->timestamps();
            // SoftDeletes removed
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artifacts');
    }
};