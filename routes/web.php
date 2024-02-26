<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;

// forma de acceder a las rutas agrupadas del proyecto
Route::controller(ProyectoController::class)->middleware('auth')->group(function () use ($router) {
    Route::get('/',                     'home')->name('home');
    Route::get('/proyecto',             'index')->name('proyectos');
    Route::get('/proyecto/{id}',        'show');
    Route::get('/proyecto/{id}/tareas', 'tareas');
    Route::post('/proyecto',            'crear')->name('crear');
    Route::get('/crear',                'cargar_crear')->name('cargar_crear');
    Route::post('/proyectofilter',      'filter');
    Route::put('/proyecto/{id}',        'edit')->name('edit');
    Route::get('/proyecto/{id}',        'cargar_editar')->name('cargar_editar');
    Route::delete('/proyecto/{id}',     'delete')->name('delete');
});

Route::resource('tareas', TareaController::class)->middleware('auth');

Route::get('/dashboard', [ProyectoController::class, 'home'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';