<?php

use App\Http\Controllers\TareaController;
use Illuminate\Support\Facades\Route;

Route::resource('tareas', TareaController::class)
    ->only(['index', 'store', 'update', 'destroy']);


Route::get('/', function () {
    return redirect()->route('tareas.index');
});