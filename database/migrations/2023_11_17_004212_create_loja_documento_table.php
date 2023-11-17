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
        Schema::create('loja_documento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loja_id')->references('id')->on('loja')->onDelete('CASCADE');
            $table->foreignId('documento_id')->references('id')->on('documento')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loja_documento');
    }
};
