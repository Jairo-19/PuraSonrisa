<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EsEmpleado
{
    /**
     * Permite el acceso solo a usuarios autenticados con rol 'empleado'.
     * Cualquier otro usuario es redirigido al login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->rol === 'empleado') {
            return $next($request);
        }

        Auth::logout();

        return redirect()->route('login');
    }
}
