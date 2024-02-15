<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;

// forma de acceder a las rutas agrupadas del proyecto
Route::controller(ProyectoController::class)->group(function () {
    Route::get('/',                     'home')->name('home');
    Route::get('/proyecto',             'index')->name('proyectos');
    Route::get('/proyecto/{id}',        'show');
    Route::get('/proyecto/{id}/tareas', 'tareas');
    Route::post('/proyecto',            'crear')->name('crear');
    Route::get('/crear',               'cargar_crear')->name('cargar_crear');
    Route::post('/proyectofilter',      'filter');
    Route::put('/proyecto/{id}',        'edit')->name('edit');
    Route::get('/proyecto/{id}',        'cargar_editar')->name('cargar_editar');
    Route::delete('/proyecto/{id}',     'delete')->name('delete');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('tareas', TareaController::class)->middleware('auth');
// Route::controller(TareaController::class)->group(function () {
//     Route::get('/tareas',                'index')->name('tareas');
//     Route::post('/proyecto/{id}/tareas', 'crear');
//     Route::get('/tareas/{id}',           'show');
//     Route::put('/tareas/{id}',           'edit');
//     Route::put('/tareas',           'editar')->name('editar');
//     Route::put('/del_tareas/{id}',       'delete')->name('delete_tarea');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
