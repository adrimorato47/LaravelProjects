<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('tareas', function () {
    return view('tareas');
});

Route::resource('tareas', TareasController::class);
