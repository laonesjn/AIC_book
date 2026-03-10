<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('title_image', 255)->nullable();
            $table->longText('content');
            $table->foreignId('main_category_id')
                ->constrained('main_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreignId('subcategory_id')
                ->constrained('subcategories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->decimal('price', 8, 2)->default(0);
            $table->enum('visibleType', ['public', 'private'])->default('public');
            $table->string('pdf', 255)->nullable();
            $table->timestamps();

            $table->index('main_category_id');
            $table->index('subcategory_id');
            $table->index('created_at');
            $table->index('visibleType');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publications');
    }
};