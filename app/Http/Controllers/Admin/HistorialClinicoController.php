<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HistorialClinico;
use App\Models\Usuario;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HistorialClinicoController extends Controller
{
    public function show(Usuario $usuario): View
    {
        $historial = $usuario->historialClinico()
            ->with('imagenes')
            ->orderBy('fecha', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.historial.show', compact('usuario', 'historial'));
    }

    public function store(Request $request, Usuario $usuario): RedirectResponse
    {
        $validated = $request->validate([
            'descripcion' => ['required', 'string', 'max:10000'],
            'fotos'       => ['nullable', 'array', 'max:10'],
            'fotos.*'     => ['file', 'mimes:jpeg,jpg,png,webp,gif', 'max:5120'],
        ]);

        $nota = $usuario->historialClinico()->create([
            'descripcion' => $validated['descripcion'],
            'fecha'       => now()->toDateString(),
        ]);

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $carpeta = public_path("imagenes/historial/{$nota->id}");
                if (! is_dir($carpeta)) {
                    mkdir($carpeta, 0755, true);
                }
                $nombre = uniqid('foto_', true) . '.' . $file->getClientOriginalExtension();
                $file->move($carpeta, $nombre);
                $nota->imagenes()->create([
                    'nombre'      => $file->getClientOriginalName(),
                    'ruta'        => "imagenes/historial/{$nota->id}/{$nombre}",
                    'tipo'        => 'foto',
                    'descripcion' => null,
                ]);
            }
        }

        return redirect()
            ->route('admin.historial.show', $usuario)
            ->with('flash_success', 'Nota añadida correctamente.');
    }

    public function destroy(HistorialClinico $historial): RedirectResponse
    {
        $pacienteId = $historial->paciente_id;

        $historial->delete();

        return redirect()
            ->route('admin.historial.show', $pacienteId)
            ->with('flash_success', 'Nota eliminada.');
    }
}
