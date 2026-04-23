<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Crea la tabla de usuarios con todos sus campos
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('rol', ['empleado', 'cliente'])->default('cliente');
            $table->string('telefono', 20)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('dni', 20)->nullable();
            $table->text('alergias')->nullable();
            $table->text('condiciones_medicas')->nullable();
            $table->timestamps();
        });
    }

    // Elimina la tabla de usuarios si se revierte la migración
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
