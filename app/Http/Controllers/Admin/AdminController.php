<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
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
}
