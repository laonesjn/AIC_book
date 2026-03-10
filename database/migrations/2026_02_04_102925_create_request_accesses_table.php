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
        Schema::create('request_accesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('publication_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->text('why');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->enum('pay_status', ['unpaid', 'paid'])->default('unpaid');
            $table->timestamps();

            // Foreign key relation (assuming publications table exists)
            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_accesses');
    }
};
