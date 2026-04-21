<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('imagenes_clinicas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('historial_id')->constrained('historial_clinico')->cascadeOnDelete();
            $table->string('nombre');
            $table->string('ruta');
            $table->enum('tipo', ['radiografia', 'foto', 'otro'])->default('foto');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('imagenes_clinicas');
    }
};
