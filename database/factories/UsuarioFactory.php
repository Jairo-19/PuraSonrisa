<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends Factory<Usuario>
 */
class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    // Define los valores por defecto para generar un usuario de prueba
    public function definition(): array
    {
        return [
            'nombre'             => fake()->name(),
            'email'              => fake()->unique()->safeEmail(),
            'password'           => Hash::make('password'),
            'rol'                => fake()->randomElement(['empleado', 'cliente']),
            'telefono'           => fake()->numerify('6########'),
            'fecha_nacimiento'   => fake()->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'dni'                => fake()->numerify('########') . fake()->randomLetter(),
            'alergias'           => fake()->optional(0.3)->sentence(),
            'condiciones_medicas'=> fake()->optional(0.2)->sentence(),
        ];
    }

    // ─── Estados ───────────────────────────────────────────────

    // Estado: usuario con rol cliente
    public function cliente(): static
    {
        return $this->state(['rol' => 'cliente']);
    }

    // Estado: usuario con rol empleado
    public function empleado(): static
    {
        return $this->state(['rol' => 'empleado']);
    }
}
