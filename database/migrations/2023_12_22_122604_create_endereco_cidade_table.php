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
        Schema::create('endereco_cidade', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cidade_id')->references('id')->on('cidade');
            $table->foreignId('endereco_id')->references('id')->on('endereco');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endereco_cidade');
    }
};
