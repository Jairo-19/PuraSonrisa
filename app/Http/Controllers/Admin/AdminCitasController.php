<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Usuario;
use App\Traits\AsignaCita;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminCitasController extends Controller
{
    use AsignaCita;

    /** GET /admin/citas/crear — Formulario para crear una cita manualmente */
    public function create(Request $request): View
    {
        $clientes      = Usuario::clientes()->orderBy('nombre')->get();
        // Se cargan todos los servicios (activos e inactivos) para que el empleado
        // pueda asignar servicios internos como la revisión de ortodoncia (0€),
        // que están inactivos y no son visibles para los clientes en el formulario público.
        $servicios     = Servicio::orderBy('nombre')->get();
        $fechaDefault  = $request->query('fecha', now()->toDateString());

        return view('admin.citas.crear', compact('clientes', 'servicios', 'fechaDefault'));
    }

    /** POST /admin/citas — Guardar la nueva cita */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'paciente_id' => ['required', 'exists:usuarios,id'],
            'servicio_id' => ['required', 'exists:servicios,id'],
            'fecha'       => ['required', 'date', 'after_or_equal:today'],
            'hora_inicio' => ['required', 'date_format:H:i'],
            'hora_fin'    => ['required', 'date_format:H:i', 'after:hora_inicio'],
            'motivo'      => ['nullable', 'string', 'max:1000'],
        ], [
            'paciente_id.required' => 'Selecciona un paciente.',
            'paciente_id.exists'   => 'El paciente seleccionado no existe.',
            'servicio_id.required' => 'Selecciona un servicio.',
            'servicio_id.exists'   => 'El servicio seleccionado no existe.',
            'fecha.required'       => 'La fecha es obligatoria.',
            'fecha.after_or_equal' => 'La fecha debe ser hoy o posterior.',
            'hora_inicio.required' => 'La hora de inicio es obligatoria.',
            'hora_fin.required'    => 'La hora de fin es obligatoria.',
            'hora_fin.after'       => 'La hora de fin debe ser posterior a la de inicio.',
        ]);

        $consultaId = $this->consultaLibre($data['fecha'], $data['hora_inicio'], $data['hora_fin']);

        if ($consultaId === null) {
            return back()
                ->withInput()
                ->with('error', 'No hay ninguna consulta disponible en ese horario. Prueba con otro tramo horario.');
        }

        $empleadoId = $this->empleadoLibre($data['fecha'], $data['hora_inicio'], $data['hora_fin']);

        Cita::create([
            'paciente_id' => $data['paciente_id'],
            'empleado_id' => $empleadoId,
            'servicio_id' => $data['servicio_id'],
            'consulta_id' => $consultaId,
            'fecha'       => $data['fecha'],
            'hora_inicio' => $data['hora_inicio'],
            'hora_fin'    => $data['hora_fin'],
            'estado'      => Cita::ESTADO_CONFIRMADA,
            'motivo'      => $data['motivo'] ?? null,
        ]);

        return redirect()
            ->route('admin.agenda', ['fecha' => $data['fecha']])
            ->with('flash_success', 'Cita creada correctamente.');
    }

    /** DELETE /admin/citas/{cita} — Eliminar una cita desde el panel de administración */
    public function destroy(Cita $cita): RedirectResponse
    {
        $cita->delete();

        return back()->with('flash_success', 'Cita eliminada. El hueco queda disponible para nuevas reservas.');
    }
}
