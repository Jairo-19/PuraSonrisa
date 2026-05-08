<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\JsonResponse;

class LimpiezaRecordatorioController extends Controller
{
    /* ──────────────────────────────────────────────
     | GET /api/citas/limpieza/recordatorio
     | Devuelve pacientes que tuvieron una limpieza dental
     | completada hace ~6 meses (180 días).
     | Usado por n8n para enviar recordatorios de higiene.
     ────────────────────────────────────────────── */
    public function __invoke(): JsonResponse
    {
        // Busca citas completadas de "Limpieza" hace 170-190 días
        // (permite margen de ±10 días alrededor de los 6 meses exactos)
        $seisMesesAtras = now()->subDays(180);
        $inicioRango = $seisMesesAtras->copy()->subDays(10);
        $finRango = $seisMesesAtras->copy()->addDays(10);

        $citas = Cita::with(['paciente', 'servicio'])
            ->whereBetween('fecha', [$inicioRango->toDateString(), $finRango->toDateString()])
            ->whereIn('estado', [Cita::ESTADO_CONFIRMADA, Cita::ESTADO_COMPLETADA])
            ->whereHas('servicio', fn($q) => $q->where('nombre', 'LIKE', '%impieza%'))
            ->get()
            // Elimina duplicados: si el paciente tuvo varias limpiezas, solo una vez
            ->unique('paciente_id')
            ->values()
            ->map(fn($cita) => [
                'nombre' => $cita->paciente->nombre,
                'email'  => $cita->paciente->email,
            ]);

        return response()->json($citas);
    }
}
