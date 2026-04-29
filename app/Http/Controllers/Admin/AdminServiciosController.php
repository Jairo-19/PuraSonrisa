<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;

class AdminServiciosController extends Controller
{
    public function index()
    {   
        
    //Obtengo los todos los servicios de la base de datos
    $servicios = Servicio::orderBy('nombre')->get();
        

        return view('admin.servicios.index', [
            'servicios' => $servicios,
        ]);

      
    }

    //Muestro la vista del formulario para crear un nuevo servicio
    public function create(){
        return view('admin.servicios.crear');
    }

    //Guardo el nuevo servicio en la base de datos
    public function store(Request $request){

        //validacion de datos del formulario
        $request->validate([
        'nombre' => ['required', 'string', 'max:255'],
        'descripcion' => ['required', 'string'],
        'precio' => ['required', 'numeric', 'min:0'],
        'duracion_minutos' => ['required', 'integer', 'min:1'],
        'imagen' => ['nullable', 'image', 'max:2048'],
        'activo' => ['nullable', 'boolean'],
    ]);

        // Guardar imagen si se subió una
        $imagen = null;
        if ($request->hasFile('imagen')) {
            $extension = $request->file('imagen')->getClientOriginalExtension();
            $imagen = uniqid() . '.' . $extension;
            $request->file('imagen')->move(public_path('imagenes'), $imagen);
        }

        // Crear el nuevo servicio
        $servicio = new Servicio();
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->precio = $request->input('precio');
        $servicio->duracion_minutos = $request->input('duracion_minutos');
        $servicio->imagen = $imagen;
        $servicio->activo = $request->boolean('activo');
        $servicio->save();

        return redirect()->route('admin.servicios.index')->with('success', 'Servicio creado exitosamente.');
    }
}
