<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Consulta;
use App\Models\Servicio;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{
    /**
     * Crea una nueva cita para el paciente autenticado.
     * Asigna automáticamente la primera consulta libre en el slot solicitado.
     */
    public function store(Request $request)
    {
        $request->validate([
            'servicio_id'  => 'required|exists:servicios,id',
            'fecha'        => 'required|date|after_or_equal:today',
            'hora_inicio'  => 'required|date_format:H:i',
            'hora_fin'     => 'required|date_format:H:i|after:hora_inicio',
        ]);

        // Buscar primera consulta activa libre en ese slot
        $consultaId = $this->consultaLibre(
            $request->fecha,
            $request->hora_inicio,
            $request->hora_fin
        );

        if ($consultaId === null) {
            return back()->with('error', 'Lo sentimos, ese horario ya no está disponible. Por favor elige otro.');
        }

        $empleadoId = $this->empleadoLibre(
            $request->fecha,
            $request->hora_inicio,
            $request->hora_fin
        );

        Cita::create([
            'paciente_id'  => Auth::id(),
            'empleado_id'  => $empleadoId,
            'servicio_id'  => $request->servicio_id,
            'consulta_id'  => $consultaId,
            'fecha'        => $request->fecha,
            'hora_inicio'  => $request->hora_inicio,
            'hora_fin'     => $request->hora_fin,
            'estado'       => 'confirmada',
            'motivo'       => $request->motivo ?? null,
        ]);

        return redirect()->route('reservas')->with('flash_success', '¡Cita confirmada con éxito! Te esperamos en la clínica.');
    }

    /**
     * Devuelve el id de la primera consulta activa que no tenga cita solapada en ese slot.
     * Retorna null si todas están ocupadas.
     */
    private function consultaLibre(string $fecha, string $horaInicio, string $horaFin): ?int
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
    private function empleadoLibre(string $fecha, string $horaInicio, string $horaFin): ?int
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

    /**
     * Elimina una cita del paciente autenticado.
     * Solo puede eliminarse si pertenece al usuario y no está completada.
     */
    public function destroy(Cita $cita)
    {
        if ($cita->paciente_id !== Auth::id()) {
            abort(403);
        }

        if ($cita->estado === 'completada') {
            return back()->with('error', 'No puedes eliminar una cita que ya ha sido completada.');
        }

        $cita->delete();

        return back()->with('flash_success', 'Cita eliminada correctamente.');
    }
}
