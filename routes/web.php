<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('listaCompra', function () {
    return view('listaCompra');
})
;