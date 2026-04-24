<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistroController;

//Aqui defino la ruta para la pagina de inicio
Route::get('/', HomeController::class)->name('home');

//Aqui defino la ruta para la pagina de servicios
Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios');





//Aqui defino la ruta de contacto 
//es una view porque no necesito un controlador para esta pagina, solo mostrar informacion de contacto
Route::view('/contacto', 'pagina.contacto')->name('contacto');

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
Route::view('/admin', 'admin.index')->name('admin');