<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /* ──────────────────────────────────────────────
     | POST /login
     | Intenta autenticar al usuario.
     | - Éxito empleado → redirige al panel de admin
     | - Éxito cliente  → redirige a la página de inicio
     | - Fallo          → redirige al login con formulario limpio
     ────────────────────────────────────────────── */
    public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'El correo electrónico no tiene un formato válido.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            /* Regenerar sesión para prevenir fijación de sesión */
            $request->session()->regenerate();

            /* Redirigir según el rol del usuario autenticado */
            if (Auth::user()->rol === 'empleado') {
                return redirect()->route('login.loading', ['next' => 'admin']);
            }

            return redirect()->route('home');
        }

        /* Fallo: volver al login con el formulario limpio (sin mensajes de error) */
        return redirect()->route('login')
            ->withInput(['email' => '']);
    }
}
