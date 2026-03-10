<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_category_id')
                ->constrained('main_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->string('name', 255);
            $table->timestamps();

            $table->unique(['main_category_id', 'name']);
            $table->index('main_category_id');
            $table->index('name');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};