<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Servicio;
use App\Models\Cita;
use Illuminate\Http\Request;

class ReservasController extends Controller
{
    // Horario de la clínica: 9:00 → 20:00 en franjas de 30 min
    private const HORA_INICIO = '09:00';
    private const HORA_FIN    = '20:00';
    private const DURACION    = 30; // minutos por franja

    public function index()
    {
        $servicios = Servicio::activos()->get();
        return view('pagina.reservas', compact('servicios'));
    }

    /**
     * AJAX: devuelve las franjas horarias para una fecha y duración del servicio.
     * Cada franja indica si está disponible (al menos 1 consulta libre) o bloqueada.
     */
    public function slots(Request $request)
    {
        $request->validate([
            'fecha'    => 'required|date|after_or_equal:today',
            'duracion' => 'required|integer|min:15|max:240',
        ]);

        $fecha    = $request->fecha;
        $duracion = (int) $request->duracion;
        $slots    = $this->generarSlots($fecha, $duracion);

        return response()->json($slots);
    }

    /**
     * Genera todas las franjas del día e indica disponibilidad.
     */
    private function generarSlots(string $fecha, int $duracion): array
    {
        $totalConsultas = Consulta::activas()->count();
        $slots = [];

        $cursor = strtotime(self::HORA_INICIO);
        $limite = strtotime(self::HORA_FIN);

        while (($cursor + $duracion * 60) <= $limite) {
            $horaInicio = date('H:i', $cursor);
            $horaFin    = date('H:i', $cursor + $duracion * 60);

            // Consultas ocupadas en este slot (alguna cita solapa)
            $consultasOcupadas = Cita::where('fecha', $fecha)
                ->where('hora_inicio', '<', $horaFin)
                ->where('hora_fin',    '>', $horaInicio)
                ->whereNotNull('consulta_id')
                ->distinct('consulta_id')
                ->count('consulta_id');

            $slots[] = [
                'hora_inicio'  => $horaInicio,
                'hora_fin'     => $horaFin,
                'disponible'   => $consultasOcupadas < $totalConsultas,
            ];

            $cursor += $duracion * 60;
        }

        return $slots;
    }
}
