<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    /** Vista de perfil del cliente autenticado */
    public function perfil()
    {
        /** @var Usuario $usuario */
        $usuario = Auth::user();
        return view('cliente.perfil', compact('usuario'));
    }

    /** Lista de citas del cliente autenticado */
    public function misCitas()
    {
        /** @var Usuario $user */
        $user  = Auth::user();
        $citas = $user->citasPaciente()
            ->with(['servicio', 'empleado'])
            ->orderByDesc('fecha')
            ->orderByDesc('hora_inicio')
            ->get();

        $total = $citas->count();

        return view('cliente.mis-citas', compact('citas', 'total'));
    }
}
