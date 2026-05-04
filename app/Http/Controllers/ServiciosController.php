<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    
    public function index()
    {
        // Servicios activos para el catálogo completo
        $servicios = Servicio::activos()->get();

        // Top 3 por número de citas para el podio
        // Se obtienen ordenados por demanda: [0]=1º, [1]=2º, [2]=3º
        // En la vista se reordenan visualmente: izquierda=2º, centro=1º, derecha=3º
        $top3 = Servicio::activos()
            ->withCount('citas')
            ->orderByDesc('citas_count')
            ->take(3)
            ->get();

        return view('pagina.servicios', compact('servicios', 'top3'));
    }

}
