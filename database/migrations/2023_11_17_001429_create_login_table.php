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
            $table->foreignId('usuario_id')->references('id')->on('usuario')->onDelete('CASCADE')->nullable()->unique();
            $table->foreignId('vendedor_id')->references('id')->on('vendedor')->onDelete('CASCADE')->nullable()->unique();
            $table->foreignId('loja_id')->references('id')->on('loja')->onDelete('CASCADE')->nullable()->unique();
            $table->string('token', 24)->unique();
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
