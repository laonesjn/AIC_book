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
        Schema::create('one_drive_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('linkable_id');
            $table->string('linkable_type');
            $table->text('url');
            $table->string('title')->nullable();
            $table->timestamps();

            $table->index(['linkable_id', 'linkable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('one_drive_links');
    }
};
