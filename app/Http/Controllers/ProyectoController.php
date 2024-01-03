<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Tarea;
use Carbon\Carbon;

class ProyectoController extends Controller {
  /**
   * metodo encargado de consultar el total de registros
   */
  public function index() {
    // Lógica para mostrar una lista de proyectos
    $proyectos = Proyecto::all();
    // Devuelve la tarea creada
    return response()->json($proyectos);
  }
  /**
   * consulta los datos del proyecto por su id
   */
  public function show(int $id) {
    // Lógica para mostrar información detallada de un proyecto específico
    $proyecto = Proyecto::find($id);
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    // Devuelve la tarea creada
    return response()->json($proyecto);
  }
  /**
   * metodo que elimina el registro -- como buena practica un registro no se debe eliminar
   * fisicamente sino logicamente en base de datos para perseverar la integridad de la informacion.
   */
  public function delete(int $id) {
    $proyecto = Proyecto::findOrFail($id);
    if ($proyecto->tareas()->count() > 0) {
      return response()->json([
        'message' => 'El proyecto no se puede eliminar porque tiene tareas asociadas.',
      ], 400);
    }
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    $proyecto->delete();
    return response()->json([
      'success' => true,
    ], 200);
  }
  /**
   * metodo que edita el registro en base de datos.
   */
  public function edit(Request $request, int $id) {
    // Lógica para editar un proyecto en la base de datos
    $proyecto = Proyecto::find($id);
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    $proyecto->titulo       = $request->input('titulo');
    $proyecto->descripcion  = $request->input('descripcion');
    $proyecto->estado_tarea = $request->input('estado_tarea');
    $proyecto->estado       = $request->input('estado');
    $proyecto->save();
    return response()->json($proyecto);
  }
  /**
   * consulta las tareas y el proyecto relacionado
   */
  public function tareas(int $id)
  {
      $proyecto = Proyecto::find($id);
      if (!$proyecto) {
        return response()->json([
          "error" => "El proyecto no existe.",
          "code"  => 404,
        ], 404);
      }
      $tareas = $proyecto->tareas;
      return response()->json([
        'proyecto' => $proyecto,
        'tareas'   => $tareas
      ]);
  }
  /**
   * crea el registro del proyecto
   */
  public function crear(Request $request)
  {
    // Crea la proyecto
    $proyecto               = new Proyecto();
    $proyecto->titulo       = $request->input('titulo');
    $proyecto->descripcion  = $request->input('descripcion');
    $proyecto->fecha_inicio = $request->input('fecha_inicio');
    $proyecto->fecha_final  = $request->input('fecha_final');
    $proyecto->estado       = $request->input('estado');
    $proyecto->save();
    // Devuelve el proyecto creada
    return response()->json($proyecto);
  }
  /**
   * consulta los proyectos por medio de los filtros
   */
  public function filter(Request $request) {
    $proyecto_model = new Proyecto();
    $validacion     = $proyecto_model->validador_filtros($request->all());
    
    if (!empty($validacion)) {
      return response()->json([
        "error" => $validacion,
        "code"  => 400,
      ], 400);
    }
    $proyecto = Proyecto::where(function ($query) use ($request) {
      $filtros = $request->input('filters');
      foreach ($filtros as $value)
        $query->where($value['field'], $value['operator'],  $value['value']); 
    })->orderBy($request->input('orderBy'), $request->input('orderDirection'))->get();
    return response()->json($proyecto);
  }
}
