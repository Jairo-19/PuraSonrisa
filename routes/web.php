<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

//Aqui defino la ruta para la pagina de inicio
Route::get('/', HomeController::class)->name('home');