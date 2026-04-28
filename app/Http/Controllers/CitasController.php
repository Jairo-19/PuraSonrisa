<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Usuario;
use App\Traits\AsignaCita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CitasController extends Controller
{
    use AsignaCita;
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
