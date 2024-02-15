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
  public function index(Request $request) {
    // Lógica para mostrar una lista de tareas
    $tareas = Tarea::where('estado', '=', '1')->paginate(10);
    // Devuelve la tarea creada
    if ($request->is('api/*'))
      return response()->json($tareas);
    else  {
      return view('tareas.tarea', [
        'tareas' => $tareas
      ]);
    }
  }
   /**
   * consulta los datos de la tarea por su id 
   */
  public function show(int $id, Request $request) {
    // Lógica para mostrar información detallada de un tarea específico
    $tarea = Tarea::find($id);
    if (!$tarea) {
      return response()->json([
        "error" => "El Tarea no existe.",
        "code" => 404,
      ], 404);
    }
    // Devuelve la tarea creada
    if ($request->is('api/*'))
      return response()->json($tarea);
  }
  /**
   * metodo encargado de consultar el total de registros paginados con estado 1
   */
  public function edit($id, Request $request) {
    // Devuelve la tarea creada
    $tarea     = Tarea::with('proyecto')->find($id);
    if ($request->is('api/*')) {
      $tarea_model = new Tarea();
      $validacion  = $tarea_model->validador_tarea($request->all());
      if (!empty($validacion)) {
        return response()->json([
          "error" => $validacion,
          "code"  => 400,
        ], 400);
      }
      if (!$tarea) {
        return response()->json([
          "error" => "La tarea no existe.",
          "code" => 404,
        ], 404);
      }
      if ($tarea->estado != 1) {
        return response()->json([
          "error" => "La tarea no no existe.",
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
    else {
      $proyectos = Proyecto::all();
      return view('tareas.edit', [
        'tarea'     => $tarea,
        'proyectos' => $proyectos
      ]);
    }
  }
  /**
   * metodo que edita el registro en base de datos.
   */
  public function update(Request $request, int $id) {
    $request->validate([
      'titulo'      =>'required',
      'descripcion' =>'required:posts,descripcion',
      'estado_tarea'=>'required',
    ],[
        'titulo.required'      =>'Este campo es requerido',
        'descripcion.required' =>'Se necesita mínimo un párrafo',
        'estado_tarea.required'=>'Este campo es Requerido',
    ]);
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
    $tarea->estado       = '1';
    $tarea->update();
    if ($request->is('api/*'))
      return response()->json($tarea);
    else
      return redirect()->route('tareas.index');
  }
  /**
   * metodo encargado de consultar el total de registros paginados con estado 1
   */
  public function create(Tarea $tarea) {
    $proyectos = Proyecto::all();
    // Devuelve la tarea creada
    return view('tareas.crear', [
      'tarea' => $tarea,
      'proyectos' => $proyectos
    ]);
  }
  /**
   * crea la tarea relacionando el proyecto.
   */
  public function store(Request $request) {
    // Valida que el proyecto exista
    $request->validate([
      'titulo'      =>'required',
      'descripcion' =>'required:posts,descripcion',
      'estado_tarea'=>'required',
    ],[
      'titulo.required'      =>'Este campo es requerido',
      'descripcion.required' =>'Este campo es requerido',
      'estado_tarea.required'=>'Este campo es Requerido',
    ]);
    $proyecto = Proyecto::find($request->input('proyecto'));
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    // Crea la tarea
    $tarea = new Tarea();
    $tarea->proyecto_id  = $request->input('proyecto');
    $tarea->titulo       = $request->input('titulo');
    $tarea->descripcion  = $request->input('descripcion');
    $tarea->estado_tarea = $request->input('estado_tarea');
    $tarea->estado       = '1';
    $tarea->proyecto()->associate($proyecto);
    $tarea->save();

    // Devuelve la tarea creada
    return redirect()->route('tareas.index');
  }
  /**
   * metodo que crea la tarea
   */
  public function crear(Request $request, int $id_proyecto) {
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
    if ($tarea->estado != 1) {
      return response()->json([
        "error" => "La tarea no no existe.",
        "code" => 404,
      ], 404);
    }
    $tarea->estado = 0;
    $tarea->update();
    if ($request->is('api/*'))
      return response()->json($tarea);
    else
      return back();

  }
  /**
   * metodo que elimina logicamente el registro en base de datos, cambia el estado.
   */
  public function destroy(Request $request, int $id) {
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
    return back();
    return response()->json($tarea);
  }
}