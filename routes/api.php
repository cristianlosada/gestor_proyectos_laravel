<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;

// forma de acceder a las rutas agrupadas del proyecto
Route::controller(ProyectoController::class)->group(function () {
    Route::get('/proyecto',             'index');
    Route::get('/proyecto/{id}',        'show');
    Route::get('/proyecto/{id}/tareas', 'tareas');
    Route::post('/proyecto',            'crear');
    Route::put('/proyecto/{id}',        'edit');
});

// forma de acceder a las rutas agrupadas de las tareas
Route::controller(TareaController::class)->group(function () {
    Route::get('/tareas',               'index');
    Route::post('/proyecto/{id}/tareas', 'crear');
});