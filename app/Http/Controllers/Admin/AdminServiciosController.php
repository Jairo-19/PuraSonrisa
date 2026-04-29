<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class AdminServiciosController extends Controller
{
    public function index()
    {   
        
    //Obtengo los todos los servicios de la base de datos
    $servicios = Servicio::orderBy('nombre')->get();
        

        return view('admin.servicios.index', [
            'servicios' => $servicios,
        ]);

      
    }

    
}
