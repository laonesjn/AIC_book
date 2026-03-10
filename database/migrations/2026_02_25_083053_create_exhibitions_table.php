<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exhibitions', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('cover_image')->nullable();
            $table->string('tour_link')->nullable();
            $table->string('exhibition_location')->nullable(); // Physical location e.g. "Hall B, Floor 2"
            $table->foreignId('category_id')
                  ->constrained('exhibition_categories')
                  ->cascadeOnDelete();
            $table->timestamps();
            // SoftDeletes removed
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exhibitions');
    }
};