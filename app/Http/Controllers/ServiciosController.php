<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Servicio;

class ServiciosController extends Controller
{
    
    public function index()
    {   //Obtengo los servicios activos de la base de datos
        $servicios = Servicio::activos()->get();
        //Retorno la vista de servicios con los servicios obtenidos
        return view('pagina.servicios', compact('servicios'));
    }

}
