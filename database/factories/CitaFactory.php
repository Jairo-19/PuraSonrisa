<?php

namespace Database\Factories;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cita>
 */
class CitaFactory extends Factory
{
    protected $model = Cita::class;

    // Define los valores por defecto para generar una cita de prueba
    public function definition(): array
    {
        $horaInicio = fake()->numberBetween(8, 16);

        return [
            'paciente_id'  => Usuario::factory()->cliente(),
            'empleado_id'  => Usuario::factory()->empleado(),
            'servicio_id'  => Servicio::factory(),
            'fecha'        => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
            'hora_inicio'  => sprintf('%02d:00:00', $horaInicio),
            'hora_fin'     => sprintf('%02d:00:00', $horaInicio + 1),
            'estado'       => fake()->randomElement(['pendiente', 'confirmada', 'completada']),
            'motivo'       => fake()->optional(0.6)->sentence(),
        ];
    }

    // ─── Estados ───────────────────────────────────────────────

    // Estado: cita pendiente
    public function pendiente(): static
    {
        return $this->state(['estado' => 'pendiente']);
    }

    // Estado: cita confirmada
    public function confirmada(): static
    {
        return $this->state(['estado' => 'confirmada']);
    }

    // Estado: cita completada
    public function completada(): static
    {
        return $this->state(['estado' => 'completada']);
    }
}
