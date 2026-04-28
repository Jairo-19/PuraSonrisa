<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    // Elimina el valor 'pendiente' del ENUM estado en la tabla citas
    public function up(): void
    {
        // Convertir citas pendientes a confirmada antes de alterar el ENUM
        DB::table('citas')->where('estado', 'pendiente')->update(['estado' => 'confirmada']);

        DB::statement("ALTER TABLE citas MODIFY COLUMN estado ENUM('confirmada', 'completada') NOT NULL DEFAULT 'confirmada'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE citas MODIFY COLUMN estado ENUM('pendiente', 'confirmada', 'completada') NOT NULL DEFAULT 'pendiente'");
    }
};
