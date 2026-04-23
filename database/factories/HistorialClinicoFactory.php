<?php

namespace Database\Factories;

use App\Models\HistorialClinico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<HistorialClinico>
 */
class HistorialClinicoFactory extends Factory
{
    protected $model = HistorialClinico::class;

    // Define los valores por defecto para generar una entrada de historial clínico de prueba
    public function definition(): array
    {
        return [
            'paciente_id' => Usuario::factory()->cliente(),
            'descripcion' => fake()->paragraph(3),
            'fecha'       => fake()->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
        ];
    }
}
