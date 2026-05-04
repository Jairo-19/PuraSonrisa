<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Usuario;

class AdminEstadisticasController extends Controller
{
    public function index()
    {
        // Total de citas del mes actual
        $totalCitasMes = Cita::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();

        // Ingresos del mes actual (solo citas completadas)
        $ingresos = Cita::where('estado', Cita::ESTADO_COMPLETADA)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
            ->sum('servicios.precio');

        // Nuevos clientes registrados este mes
        $nuevosClientes = Usuario::clientes()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Top 5 servicios más reservados
        $serviciosTop = Servicio::withCount('citas')
            ->orderByDesc('citas_count')
            ->take(5)
            ->get();

        return view('admin.estadisticas.index', compact(
            'totalCitasMes',
            'ingresos',
            'nuevosClientes',
            'serviciosTop'
        ));
    }
}
