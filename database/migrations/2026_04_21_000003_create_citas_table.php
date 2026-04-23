<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla de citas con sus relaciones a usuarios y servicios
    public function up(): void
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('empleado_id')->constrained('usuarios')->cascadeOnDelete();
            $table->foreignId('servicio_id')->constrained('servicios')->cascadeOnDelete();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->enum('estado', ['pendiente', 'confirmada', 'completada'])->default('pendiente');
            $table->text('motivo')->nullable();
            $table->timestamps();
        });
    }

    // Elimina la tabla de citas si se revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('citas');
    }
};
