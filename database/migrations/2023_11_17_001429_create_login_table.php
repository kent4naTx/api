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
        Schema::create('login', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usuario_id')->nullable()->references('id')->on('usuario')->onDelete('CASCADE')->unique();
            $table->foreignId('vendedor_id')->nullable()->references('id')->on('vendedor')->onDelete('CASCADE')->unique();
            $table->foreignId('loja_id')->nullable()->references('id')->on('loja')->onDelete('CASCADE')->unique();
            $table->string('token', 48)->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('login');
    }
};
