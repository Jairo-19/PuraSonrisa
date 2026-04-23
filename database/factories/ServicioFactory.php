<?php

namespace Database\Factories;

use App\Models\Servicio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Servicio>
 */
class ServicioFactory extends Factory
{
    protected $model = Servicio::class;

    // Define los valores por defecto para generar un servicio de prueba
    public function definition(): array
    {
        $servicios = [
            'Limpieza Dental', 'Blanqueamiento', 'Ortodoncia',
            'Implantes', 'Endodoncia', 'Extracción', 'Revisión General',
        ];

        return [
            'nombre'            => fake()->unique()->randomElement($servicios),
            'descripcion'       => fake()->paragraph(),
            'precio'            => fake()->randomFloat(2, 20, 3000),
            'duracion_minutos'  => fake()->randomElement([30, 45, 60, 90]),
            'activo'            => true,
            'imagen'            => null,
        ];
    }
}
