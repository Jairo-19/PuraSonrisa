<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\ReservasController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCitasController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\HistorialClinicoController;
use App\Http\Controllers\Admin\AdminServiciosController;
use App\Http\Controllers\Admin\AdminEstadisticasController;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\ClienteController;

//Aqui defino la ruta para la pagina de inicio
Route::get('/', HomeController::class)->name('home');

//Aqui defino la ruta para la pagina de servicios
Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios');





//Aqui defino la ruta de contacto 
//es una view porque no necesito un controlador para esta pagina, solo mostrar informacion de contacto
Route::view('/contacto', 'pagina.contacto')->name('contacto');

// Página de reservas
Route::get('/reservas', [ReservasController::class, 'index'])->name('reservas');

// AJAX: slots disponibles para una fecha y duración (accesible sin auth para poder ver disponibilidad)
Route::get('/reservas/slots', [ReservasController::class, 'slots'])->name('reservas.slots');

// Confirmar reserva — requiere estar autenticado como cliente
Route::post('/reservas', [CitasController::class, 'store'])->middleware('auth')->name('citas.store');

// Área de cliente
Route::middleware('auth')->group(function () {
    Route::get('/mi-perfil',         [ClienteController::class, 'perfil'])->name('perfil');
    Route::get('/mis-citas',         [ClienteController::class, 'misCitas'])->name('mis-citas');
    Route::delete('/mis-citas/{cita}', [CitasController::class, 'destroy'])->name('citas.destroy');
});

// Rutas de login
// El usuario siempre entra primero por la pantalla de carga
Route::view('/login/cargando', 'login.loading')->name('login.loading');

// La pantalla de carga redirige aqui tras la animacion
Route::view('/login', 'login.index')->name('login');

// Procesa el formulario de login
Route::post('/login', LoginController::class)->name('login.submit');

// Ruta del registro de nuevos usuarios
Route::view('/registro', 'login.registro')->name('registro');

// Procesa el formulario de registro
Route::post('/registro', RegistroController::class)->name('registro.submit');

// Cierra la sesion del usuario autenticado
Route::post('/logout', function () {
    \Illuminate\Support\Facades\Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('home');
})->name('logout');

// Panel de administración — solo accesible para empleados autenticados
Route::middleware(['auth', 'empleado'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.usuarios'))->name('index');
    Route::get('/usuarios',                  [AdminController::class, 'usuarios'])->name('usuarios');
    Route::get('/usuarios/crear',            [AdminController::class, 'crear'])->name('usuarios.crear');
    Route::post('/usuarios',                 [AdminController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{usuario}/editar', [AdminController::class, 'editar'])->name('usuarios.editar');
    Route::put('/usuarios/{usuario}',        [AdminController::class, 'update'])->name('usuarios.update');

    // Agenda / Calendario
    Route::get('/agenda',     [AgendaController::class, 'dia'])->name('agenda');
    Route::get('/agenda/mes', [AgendaController::class, 'mes'])->name('agenda.mes');

    // Gestión de citas desde el panel de administración
    Route::get('/citas/crear',     [AdminCitasController::class, 'create'])->name('citas.crear');
    Route::post('/citas',          [AdminCitasController::class, 'store'])->name('citas.store');
    Route::delete('/citas/{cita}', [AdminCitasController::class, 'destroy'])->name('citas.destroy');

    // Historial clínico por paciente
    Route::get('/pacientes/{usuario}/historial',  [HistorialClinicoController::class, 'show'])->name('historial.show');
    Route::post('/pacientes/{usuario}/historial', [HistorialClinicoController::class, 'store'])->name('historial.store');
    Route::delete('/historial/{historial}',       [HistorialClinicoController::class, 'destroy'])->name('historial.destroy');

    //Rutas para gestionar los servicios
    Route::get('/servicios',                   [AdminServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear',             [AdminServiciosController::class, 'create'])->name('servicios.crear');
    Route::post('/servicios',                  [AdminServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [AdminServiciosController::class, 'edit'])->name('servicios.editar');
    Route::put('/servicios/{servicio}',        [AdminServiciosController::class, 'update'])->name('servicios.update');
    Route::delete('/servicios/{servicio}',     [AdminServiciosController::class, 'destroy'])->name('servicios.destroy');
    
    //Ruta de las estadisticas
    Route::get('/estadisticas', [AdminEstadisticasController::class, 'index'])->name('estadisticas.index');
    });