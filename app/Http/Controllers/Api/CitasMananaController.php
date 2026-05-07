<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use Illuminate\Http\JsonResponse;

class CitasMananaController extends Controller
{
    /* ──────────────────────────────────────────────
     | GET /api/citas/manana
     | Devuelve las citas confirmadas del día siguiente
     | con los datos del paciente y servicio.
     | Usado por n8n para enviar recordatorios por email.
     ────────────────────────────────────────────── */
    public function __invoke(): JsonResponse
    {
        $manana = now()->addDay()->toDateString();

        $citas = Cita::with(['paciente', 'servicio'])
            ->whereDate('fecha', $manana)
            ->where('estado', Cita::ESTADO_CONFIRMADA)
            ->get()
            ->map(fn($cita) => [
                'nombre'      => $cita->paciente->nombre,
                'email'       => $cita->paciente->email,
                'fecha'       => $cita->fecha->format('d/m/Y'),
                'hora_inicio' => substr($cita->hora_inicio, 0, 5),
                'servicio'    => $cita->servicio->nombre,
            ]);

        return response()->json($citas);
    }
}
