<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Servicio;
use App\Models\Usuario;

// Controlador exclusivo para la sección de estadísticas del panel de administración.
// Solo contiene el método index() porque esta sección es de solo lectura: no hay creación,
// edición ni borrado de datos, únicamente consultas a la base de datos.
class AdminEstadisticasController extends Controller
{
    // Método que se ejecuta al acceder a /admin/estadisticas
    // Recoge todos los datos necesarios y los pasa a la vista
    public function index()
    {
        // Cuenta cuántas citas hay en el mes y año actuales, sin importar su estado
        $totalCitasMes = Cita::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();

        // Suma el precio del servicio de cada cita completada este mes.
        // Se hace un JOIN con la tabla servicios porque el precio vive ahí, no en citas.
        // Solo se cuentan citas con estado 'completada' ya que son las que generan ingreso real.
        $ingresos = Cita::where('estado', Cita::ESTADO_COMPLETADA)
            ->whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->join('servicios', 'citas.servicio_id', '=', 'servicios.id')
            ->sum('servicios.precio');

        // Cuenta los usuarios con rol 'cliente' cuya fecha de registro (created_at)
        // pertenece al mes y año actuales. Usa el scope clientes() definido en el modelo Usuario.
        $nuevosClientes = Usuario::clientes()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // Obtiene los 5 servicios con más citas asociadas.
        // withCount('citas') añade un atributo virtual 'citas_count' a cada servicio
        // con el total de citas que tiene ese servicio en la tabla citas.
        $serviciosTop = Servicio::withCount('citas')
            ->orderByDesc('citas_count')
            ->take(5)
            ->get();

        // compact() convierte las variables locales en un array asociativo
        // que Blade recibe como variables independientes en la vista
        return view('admin.estadisticas.index', compact(
            'totalCitasMes',
            'ingresos',
            'nuevosClientes',
            'serviciosTop'
        ));
    }
}
