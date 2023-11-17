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
        Schema::create('vendedor_telefone', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendedor_id')->references('id')->on('vendedor')->onDelete('CASCADE');
            $table->foreignId('telefone_id')->references('id')->on('telefone')->onDelete('CASCADE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendedor_telefone');
    }
};
