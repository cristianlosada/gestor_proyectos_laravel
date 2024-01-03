<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Proyecto;
use App\Models\Tarea;

class TareaController extends Controller
{
  /**
   * metodo encargado de consultar el total de registros paginados con estado 1
   */
  public function index() {
    // Lógica para mostrar una lista de tareas
    $tareas = Tarea::where('estado', '=', '1')->paginate(10);
    // Devuelve la tarea creada
    return response()->json($tareas);
  }
  /**
   * consulta los datos de la tarea por su id 
   */
  public function show(int $id) {
    // Lógica para mostrar información detallada de un tarea específico
    $tarea = Tarea::find($id);
    if (!$tarea) {
      return response()->json([
        "error" => "El Tarea no existe.",
        "code" => 404,
      ], 404);
    }
    // Devuelve la tarea creada
    return response()->json($tarea);
  }
  /**
   * metodo que edita el registro en base de datos.
   */
  public function edit(Request $request, int $id) {
    // Lógica para editar un tarea en la base de datos
    $tarea = Tarea::find($id);
    if (!$tarea) {
      return response()->json([
        "error" => "La tarea no existe.",
        "code" => 404,
      ], 404);
    }
    $tarea->titulo       = $request->input('titulo');
    $tarea->descripcion  = $request->input('descripcion');
    $tarea->estado_tarea = $request->input('estado_tarea');
    $tarea->estado       = $request->input('estado');
    $tarea->update();
    return response()->json($tarea);
  }
  /**
   * metodo que elimina logicamente el registro en base de datos, cambia el estado.
   */
  public function delete(Request $request, int $id) {
    // Lógica para editar un tarea en la base de datos
    $tarea = Tarea::find($id);
    if (!$tarea) {
      return response()->json([
        "error" => "La tarea no existe.",
        "code" => 404,
      ], 404);
    }
    $tarea->estado = 0;
    $tarea->update();
    return response()->json($tarea);
  }
  /**
   * crea la tarea relacionando el proyecto.
   */
  public function crear(Request $request, int $id_proyecto)
  {
    // Valida que el proyecto exista
    $proyecto = Proyecto::find($id_proyecto);
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    // Crea la tarea
    $tarea = new Tarea();
    $tarea->proyecto_id  = $id_proyecto;
    $tarea->titulo       = $request->input('titulo');
    $tarea->descripcion  = $request->input('descripcion');
    $tarea->estado_tarea = $request->input('estado_tarea');
    $tarea->estado       = $request->input('estado');
    $tarea->proyecto()->associate($proyecto);
    $tarea->save();

    // Devuelve la tarea creada
    return response()->json($tarea);
  }
}
