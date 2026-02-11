<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('configurations', function (Blueprint $table) {
            $table->id();
            $table->string('config_id')->unique();
            $table->string('nome')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('luogo_carico')->nullable();
            $table->string('luogo_scarico')->nullable();
            $table->decimal('distanza_totale', 10, 2)->nullable();
            $table->decimal('tempo_totale', 10, 2)->nullable();
            $table->string('tipo_trasporto')->default('solo_trasporto');
            $table->boolean('imballaggio')->default(false);
            $table->boolean('ztl')->default(false);
            $table->boolean('ascensore')->default(false);
            $table->integer('piano_carico')->default(0);
            $table->integer('piano_scarico')->default(0);
            $table->json('stanze_selezionate')->nullable();
            $table->json('furniture_config')->nullable();
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('total_carico_time', 10, 2)->default(0);
            $table->decimal('total_scarico_time', 10, 2)->default(0);
            $table->decimal('transport_cost', 10, 2)->default(0);
            $table->json('booking_details')->nullable();
            $table->integer('current_step')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('configurations');
    }
};
