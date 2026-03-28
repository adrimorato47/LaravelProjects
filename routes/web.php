<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TareasController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tareas', TareasController::class);
