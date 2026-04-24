<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminController extends Controller
{
    /** GET /admin/usuarios — Listado de todos los usuarios */
    public function usuarios(): View
    {
        $usuarios = Usuario::orderBy('nombre')->get();

        return view('admin.index', [
            'seccion'  => 'usuarios',
            'usuarios' => $usuarios,
        ]);
    }

    /** GET /admin/usuarios/crear — Formulario de creación */
    public function crear(): View
    {
        return view('admin.usuarios.crear');
    }

    /** POST /admin/usuarios — Guardar nuevo usuario */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'nombre'               => ['required', 'string', 'max:255'],
            'email'                => ['required', 'email', 'max:255', 'unique:usuarios,email'],
            'password'             => ['required', 'string', 'min:8', 'confirmed'],
            'rol'                  => ['required', 'in:cliente,empleado'],
            'telefono'             => ['nullable', 'string', 'max:20'],
            'fecha_nacimiento'     => ['nullable', 'date', 'before:today'],
            'dni'                  => ['nullable', 'string', 'max:20'],
            'alergias'             => ['nullable', 'string'],
            'condiciones_medicas'  => ['nullable', 'string'],
        ], [
            'nombre.required'   => 'El nombre es obligatorio.',
            'email.required'    => 'El correo electrónico es obligatorio.',
            'email.email'       => 'El correo no tiene un formato válido.',
            'email.unique'      => 'Ya existe un usuario con ese correo.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min'      => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'rol.required'      => 'El rol es obligatorio.',
            'rol.in'            => 'El rol debe ser cliente o empleado.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
        ]);

        $data['password'] = Hash::make($data['password']);

        Usuario::create($data);

        return redirect()->route('admin.usuarios')
            ->with('success', 'Usuario creado correctamente.');
    }

    /** GET /admin/usuarios/{usuario}/editar — Formulario de edición */
    public function editar(Usuario $usuario): View
    {
        return view('admin.usuarios.editar', compact('usuario'));
    }

    /** PUT /admin/usuarios/{usuario} — Actualizar usuario */
    public function update(Request $request, Usuario $usuario): RedirectResponse
    {
        $data = $request->validate([
            'nombre'              => ['required', 'string', 'max:255'],
            'email'               => ['required', 'email', 'max:255', 'unique:usuarios,email,' . $usuario->id],
            'password'            => ['nullable', 'string', 'min:8', 'confirmed'],
            'rol'                 => ['required', 'in:cliente,empleado'],
            'telefono'            => ['nullable', 'string', 'max:20'],
            'fecha_nacimiento'    => ['nullable', 'date', 'before:today'],
            'dni'                 => ['nullable', 'string', 'max:20'],
            'alergias'            => ['nullable', 'string'],
            'condiciones_medicas' => ['nullable', 'string'],
        ], [
            'nombre.required'         => 'El nombre es obligatorio.',
            'email.required'          => 'El correo electrónico es obligatorio.',
            'email.email'             => 'El correo no tiene un formato válido.',
            'email.unique'            => 'Ya existe un usuario con ese correo.',
            'password.min'            => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'      => 'Las contraseñas no coinciden.',
            'rol.required'            => 'El rol es obligatorio.',
            'rol.in'                  => 'El rol debe ser cliente o empleado.',
            'fecha_nacimiento.before' => 'La fecha de nacimiento debe ser anterior a hoy.',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $usuario->update($data);

        return redirect()->route('admin.usuarios')
            ->with('success', 'Usuario actualizado correctamente.');
    }
}
