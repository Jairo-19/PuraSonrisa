<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistroController extends Controller
{
    /* ──────────────────────────────────────────────
     | POST /registro
     | Crea un nuevo usuario con rol "cliente",
     | lo autentica automáticamente y redirige al inicio.
     ────────────────────────────────────────────── */
    public function __invoke(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'              => ['required', 'string', 'max:255'],
            'email'               => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'password'            => ['required', 'string', 'min:8', 'confirmed'],
            /* DNI: 8 dígitos + 1 letra mayúscula  |  NIE: X/Y/Z + 7 dígitos + 1 letra mayúscula */
            'dni'                 => ['nullable', 'string', 'regex:/^([0-9]{8}[A-Z]|[XYZ][0-9]{7}[A-Z])$/'],
            /* Teléfono español: exactamente 9 dígitos empezando por 6, 7, 8 o 9 (el prefijo +34 se añade al guardar) */
            'telefono'            => ['nullable', 'string', 'regex:/^[6789][0-9]{8}$/'],
            /* Fecha de nacimiento: no puede ser futura ni superar los 120 años */
            'fecha_nacimiento'    => ['nullable', 'date', 'before:today', 'after:' . now()->subYears(120)->toDateString()],
            'alergias'            => ['nullable', 'string'],
            'condiciones_medicas' => ['nullable', 'string'],
        ], [
            'nombre.required'         => 'El nombre es obligatorio.',
            'nombre.max'              => 'El nombre no puede superar los 255 caracteres.',
            'email.required'          => 'El correo electrónico es obligatorio.',
            'email.email'             => 'El correo electrónico no tiene un formato válido.',
            'email.max'               => 'El correo electrónico no puede superar los 255 caracteres.',
            'email.unique'            => 'Este correo electrónico ya está registrado.',
            'password.required'       => 'La contraseña es obligatoria.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'      => 'Las contraseñas no coinciden.',
            'dni.regex'               => 'El DNI debe tener 8 dígitos y 1 letra mayúscula (ej: 12345678A). El NIE debe tener X/Y/Z, 7 dígitos y 1 letra mayúscula (ej: X1234567A).',
            'telefono.regex'          => 'El teléfono debe tener 9 dígitos y empezar por 6, 7, 8 o 9.',
            'fecha_nacimiento.date'   => 'La fecha de nacimiento no es válida.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento no puede ser en el futuro.',
            'fecha_nacimiento.after'  => 'La fecha de nacimiento no puede ser hace más de 120 años.',
        ]);

        /* Añadir prefijo +34 al teléfono si se ha introducido */
        if (!empty($data['telefono'])) {
            $data['telefono'] = '+34' . $data['telefono'];
        }

        /* Crear usuario con contraseña hasheada y rol cliente */
        $usuario = Usuario::create([
            ...$data,
            'password' => Hash::make($data['password']),
            'rol'      => 'cliente',
        ]);

        /* Autenticar al nuevo usuario automáticamente */
        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
