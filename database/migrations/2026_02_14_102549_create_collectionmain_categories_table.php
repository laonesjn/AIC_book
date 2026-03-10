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
        Schema::create('collectionmain_categories', function (Blueprint $table) {
            $table->id();
            
            // Add foreign key to master_main_categories
            $table->unsignedBigInteger('master_main_category_id')->nullable();
            
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('view_count')->default(0);
            $table->timestamps();
            
            // Define the foreign key relationship
            $table->foreign('master_main_category_id')
                ->references('id')
                ->on('master_main_categories')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collectionmain_categories');
    }
};