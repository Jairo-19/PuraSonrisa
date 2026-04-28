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

    /** Lista de citas futuras del cliente autenticado */
    public function misCitas()
    {
        /** @var Usuario $user */
        $user  = Auth::user();
        $citas = $user->citasPaciente()
            ->with(['servicio', 'empleado'])
            ->where(function ($q) {
                $hoy  = now()->toDateString();
                $ahora = now()->format('H:i:s');
                $q->where('fecha', '>', $hoy)
                  ->orWhere(function ($q2) use ($hoy, $ahora) {
                      $q2->where('fecha', $hoy)
                         ->where('hora_inicio', '>=', $ahora);
                  });
            })
            ->orderBy('fecha')
            ->orderBy('hora_inicio')
            ->get();

        $total = $citas->count();

        return view('cliente.mis-citas', compact('citas', 'total'));
    }
}
