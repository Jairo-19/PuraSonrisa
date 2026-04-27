<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Añade consulta_id a citas y hace nullable empleado_id para asignación automática
    public function up(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            // FK a la consulta (gabinete) donde se atiende la cita
            $table->foreignId('consulta_id')
                  ->nullable()
                  ->after('servicio_id')
                  ->constrained('consultas')
                  ->nullOnDelete();

            // Hacemos empleado_id nullable para que el sistema lo asigne automáticamente
            $table->foreignId('empleado_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('citas', function (Blueprint $table) {
            $table->dropForeign(['consulta_id']);
            $table->dropColumn('consulta_id');
            $table->foreignId('empleado_id')->nullable(false)->change();
        });
    }
};
