<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\HistorialClinico;
use App\Models\ImagenClinica;
use App\Models\Cita;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Pobla la base de datos con datos de prueba.
     */
    public function run(): void
    {
        // Servicios reales
        $this->call(ServiciosSeeder::class);

        // Consultas (gabinetes físicos de la clínica)
        $this->call(ConsultasSeeder::class);

        // 2 empleados
        Usuario::factory()->empleado()->count(2)->create();

        // 5 clientes con historial y citas
        Usuario::factory()->cliente()->count(5)->create()->each(function ($cliente) {

            // 1-2 entradas de historial con 0-1 imágenes cada una
            HistorialClinico::factory()
                ->count(rand(1, 2))
                ->create(['paciente_id' => $cliente->id])
                ->each(fn($h) => ImagenClinica::factory()->count(rand(0, 1))->create(['historial_id' => $h->id]));

            // 1-3 citas por cliente
            $empleado = Usuario::where('rol', 'empleado')->inRandomOrder()->first();
            Cita::factory()->count(rand(1, 3))->create([
                'paciente_id' => $cliente->id,
                'empleado_id' => $empleado->id,
                'servicio_id' => \App\Models\Servicio::inRandomOrder()->first()->id,
            ]);
        });
    }
}
