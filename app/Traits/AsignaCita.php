<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Usuario;

trait AsignaCita
{
    /**
     * Devuelve el id de la primera consulta activa que no tenga cita solapada en ese slot.
     * Retorna null si todas están ocupadas.
     */
    protected function consultaLibre(string $fecha, string $horaInicio, string $horaFin): ?int
    {
        $consultas = Consulta::activas()->get();

        foreach ($consultas as $consulta) {
            $solapada = Cita::where('consulta_id', $consulta->id)
                ->where('fecha', $fecha)
                ->where('hora_inicio', '<', $horaFin)
                ->where('hora_fin',    '>', $horaInicio)
                ->exists();

            if (!$solapada) {
                return $consulta->id;
            }
        }

        return null;
    }

    /**
     * Devuelve el id del empleado con menos citas ese día que no tenga solapamiento.
     * Retorna null si no hay ninguno disponible.
     */
    protected function empleadoLibre(string $fecha, string $horaInicio, string $horaFin): ?int
    {
        $empleados = Usuario::empleados()->get();

        // Cargar citas del día para todos los empleados en una sola query
        $citasDelDia = Cita::whereIn('empleado_id', $empleados->pluck('id'))
            ->where('fecha', $fecha)
            ->get()
            ->groupBy('empleado_id');

        $mejorEmpleado = null;
        $menosCitas    = PHP_INT_MAX;

        foreach ($empleados as $empleado) {
            $citasEmpleado = $citasDelDia->get($empleado->id, collect());

            // Comprobar solapamiento
            $solapada = $citasEmpleado->contains(function ($cita) use ($horaInicio, $horaFin) {
                return $cita->hora_inicio < $horaFin && $cita->hora_fin > $horaInicio;
            });

            if ($solapada) {
                continue;
            }

            $total = $citasEmpleado->count();
            if ($total < $menosCitas) {
                $menosCitas    = $total;
                $mejorEmpleado = $empleado->id;
            }
        }

        return $mejorEmpleado;
    }
}
