<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla de imágenes asociadas al historial clínico
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

    // Elimina la tabla de imágenes clínicas si se revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('imagenes_clinicas');
    }
};
