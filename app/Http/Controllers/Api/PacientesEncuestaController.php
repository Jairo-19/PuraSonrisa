<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\JsonResponse;

class PacientesEncuestaController extends Controller
{
    /* ──────────────────────────────────────────────
     | GET /api/pacientes/encuesta
     | Devuelve pacientes únicos que tuvieron citas
     | en los últimos 7 días (últimas consultas).
     | Usado por n8n para enviar encuestas de satisfacción.
     ────────────────────────────────────────────── */
    public function __invoke(): JsonResponse
    {
        // Busca citas de los últimos 7 días (confirmadas o completadas)
        $haceSieteDias = now()->subDays(7)->toDateString();
        $hoy = now()->toDateString();

        $citas = Cita::with(['paciente'])
            ->whereBetween('fecha', [$haceSieteDias, $hoy])
            ->whereIn('estado', [Cita::ESTADO_CONFIRMADA, Cita::ESTADO_COMPLETADA])
            ->get()
            // Elimina duplicados: si el paciente vino varias veces, solo un email
            ->unique('paciente_id')
            ->values()
            ->map(fn($cita) => [
                'nombre' => $cita->paciente->nombre,
                'email'  => $cita->paciente->email,
            ]);

        return response()->json($citas);
    }
}
