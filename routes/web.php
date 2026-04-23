<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ServiciosController;

//Aqui defino la ruta para la pagina de inicio
Route::get('/', HomeController::class)->name('home');

//Aqui defino la ruta para la pagina de servicios
Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios');





//Aqui defino la ruta de contacto 
//es una view porque no necesito un controlador para esta pagina, solo mostrar informacion de contacto
Route::view('/contacto', 'pagina.contacto')->name('contacto');