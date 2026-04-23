<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla del historial clínico de los pacientes
    public function up(): void
    {
        Schema::create('historial_clinico', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('usuarios')->cascadeOnDelete();
            $table->text('descripcion');
            $table->date('fecha');
            $table->timestamps();
        });
    }

    // Elimina la tabla de historial clínico si se revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('historial_clinico');
    }
};
