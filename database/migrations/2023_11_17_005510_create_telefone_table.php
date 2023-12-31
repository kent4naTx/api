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
        Schema::create('telefone', function (Blueprint $table) {
            $table->id();
            $table->string('numero', 15)->unique();
            $table->enum('tipo', ['FIXO', 'CELULAR']);
            $table->boolean('principal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefone');
    }
};
