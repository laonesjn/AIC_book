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
        Schema::create('collections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('master_main_category_id')->constrained('master_main_categories')->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('title_image')->nullable();
            $table->json('images')->nullable();
            $table->enum('access_type', ['Public', 'Private'])->default('Public');
            $table->string('pdf')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collections');
    }
};
