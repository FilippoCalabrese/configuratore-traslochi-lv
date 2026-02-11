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
        Schema::create('furnish_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('image')->nullable();
            $table->unsignedInteger('min_properties')->nullable();
            $table->string('label')->nullable();
            $table->decimal('base_price', 8, 2)->nullable();
            $table->decimal('base_m3', 8, 3)->nullable();
            $table->unsignedInteger('base_tempo_carico')->nullable();
            $table->unsignedInteger('base_tempo_scarico')->nullable();
            $table->json('properties')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('furnish_items');
    }
};
