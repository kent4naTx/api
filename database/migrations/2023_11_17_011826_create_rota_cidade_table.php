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
        Schema::create('rota_cidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rota_id')->references('id')->on('rota')->onDelete('CASCADE');
            $table->foreignId('cidade_id')->references('id')->on('cidade')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rota_cidade');
    }
};
