<?php

namespace Database\Factories;

use App\Models\HistorialClinico;
use App\Models\ImagenClinica;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ImagenClinica>
 */
class ImagenClinicaFactory extends Factory
{
    protected $model = ImagenClinica::class;

    // Define los valores por defecto para generar una imagen clínica de prueba
    public function definition(): array
    {
        $extensiones = ['jpg', 'png', 'webp'];
        $ext         = fake()->randomElement($extensiones);
        $nombre      = fake()->uuid() . '.' . $ext;

        return [
            'historial_id' => HistorialClinico::factory(),
            'nombre'       => $nombre,
            'ruta'         => 'imagenes/clinicas/' . $nombre,
            'tipo'         => fake()->randomElement(['radiografia', 'foto', 'otro']),
            'descripcion'  => fake()->optional(0.5)->sentence(),
        ];
    }
}
