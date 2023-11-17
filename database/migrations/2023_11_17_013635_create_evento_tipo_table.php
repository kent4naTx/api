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
        Schema::create('evento_tipo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evento_id')->references('id')->on('evento')->onDelete('CASCADE');
            $table->foreignId('tipo_evento_id')->references('id')->on('tipo_evento')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evento_tipo');
    }
};
