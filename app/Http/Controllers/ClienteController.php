<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /** Vista de perfil del cliente autenticado */
    public function perfil()
    {
        $usuario = Auth::user();
        return view('cliente.perfil', compact('usuario'));
    }

    /** Lista de citas del cliente autenticado */
    public function misCitas()
    {
        $citas = Auth::user()
            ->citasPaciente()
            ->with(['servicio', 'empleado'])
            ->orderByDesc('fecha')
            ->orderByDesc('hora_inicio')
            ->get();

        return view('cliente.mis-citas', compact('citas'));
    }
}
