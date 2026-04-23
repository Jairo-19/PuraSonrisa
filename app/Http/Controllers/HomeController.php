<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Controlador invocable para la página de inicio
class HomeController extends Controller
{
    // Devuelve la vista principal de la página de inicio
    public function __invoke()
    {
        return view('pagina.home');
    }
}
