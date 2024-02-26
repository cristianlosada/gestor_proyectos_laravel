<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Tarea;
use Carbon\Carbon;
use App\Models\RoleUser;

class ProyectoController extends Controller {
  public function __construct() {
    
  }
  public function home(Request $request) {
    $fechaInicio = $request->get('fecha_inicio');
    $fechaFinal  = $request->get('fecha_final');
    $buscador    = $request->get('buscador');
    $ordenar     = $request->get('ordenar');
    $direccion   = $request->get('direccion');
    //
    $proyectos = Proyecto::with('tareas');
    // Filtro por fecha
    // Filtro por fecha, descripcion y estado (con múltiples condiciones)
    if ($fechaInicio && $fechaFinal && $buscador) {
      $proyectos->where(function ($query) use ($request) {
        $query->whereBetween('fecha_inicio', [$request->get('fecha_inicio'), $request->get('fecha_final')])
          ->where(function ($query) use ($request) {
            $query->where('descripcion', 'like', '%' . $request->get('buscador') . '%')
              ->orWhere('titulo', 'like', '%' . $request->get('buscador') . '%');
          });
      });
    }
    else if ($fechaInicio && $fechaFinal)
      $proyectos = $proyectos->whereBetween('fecha_inicio', [$fechaInicio, $fechaFinal]);
    else if ($buscador) {
      $proyectos = $proyectos->Where('descripcion', 'like', '%' . $buscador . '%')
      ->OrWhere('titulo', 'like', '%' . $buscador . '%');
    }
    if ($ordenar && $direccion){
      $proyectos->orderBy($ordenar, $direccion);
      $direccion = $direccion == 'asc' ? 'desc' : 'asc';
    }
    $proyectos = $proyectos->paginate(50);
    // $proyectos = Proyecto::with('tareas')->where('estado', '=', '1')->orderBy('created_at', 'desc')->paginate(10);
    return view('dashboard', [
      'proyectos' => $proyectos,
      'ordenar'   => $ordenar,
      'direccion' => $direccion]);
  }
  /**
   * metodo encargado de consultar el total de registros
   */
  public function index() {
    // Lógica para mostrar una lista de proyectos
    $proyectos = Proyecto::with('tareas')->where('estado', '=', '1')->orderBy('created_at', 'desc')->paginate(10);
    $role = RoleUser::with('role')->where('user_id', '=', auth()->user()->id)->paginate(10);
    $role = $role->getCollection()->first();
    // Devuelve la tarea creada
    return view('proyectos.proyecto', ['proyectos' => $proyectos, 'role' => $role]);
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
    $proyecto = Proyecto::with('tareas')->findOrFail($id);
    if ($proyecto->tareas()->count() > 0) {
      return response()->json([
        'message' => $proyecto,
      ], 400);
    }
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    $proyecto->delete();
    return back();
    return response()->json([
      'success' => true,
    ], 200);
  }
  public function cargar_editar(int $id) {
    $proyecto = Proyecto::find($id);
    return view('proyectos.edit', [
      'proyecto' => $proyecto
    ]);
  }
  /**
   * metodo que edita el registro en base de datos.
   */
  public function edit(Request $request, int $id) {
    // Lógica para editar un proyecto en la base de datos
    $proyecto = Proyecto::find($id);
    $request->validate([
      'titulo'       => 'required',
      'descripcion'  => 'required:posts,descripcion',
      'fecha_inicio' => 'required|date|before_or_equal:fecha_final',
      'fecha_final'  => 'required|date|after_or_equal:fecha_inicio',
    ],[
        'titulo.required'      =>'Este campo es requerido',
        'descripcion.required' =>'Este campo es requerido',
        'fecha_inicio.required'=>'Este campo es Requerido',
        'fecha_final.required' =>'Este campo es Requerido',
        'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser mayor o igual que la fecha final.',
        'fecha_final.after_or_equal' => 'La fecha final debe ser menor o igual que la fecha de inicio.',
    ]);
    if (!$proyecto) {
      return response()->json([
        "error" => "El proyecto no existe.",
        "code" => 404,
      ], 404);
    }
    $proyecto->titulo       = $request->input('titulo');
    $proyecto->descripcion  = $request->input('descripcion');
    $proyecto->fecha_inicio = $request->input('fecha_inicio');
    $proyecto->fecha_final  = $request->input('fecha_final');
    $proyecto->estado       = '1';
    $proyecto->update();
    if ($request->is('api/*'))
      return response()->json($proyecto);
    else
      return redirect()->route('proyectos');
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
   * crea el
   *  registro del proyecto
   */ 
  public function cargar_crear(Proyecto $proyecto)
  {
    return view('proyectos.crear', ['proyecto' => $proyecto]);
  }
  /**
   * crea el
   *  registro del proyecto
   */ 
  public function crear(Request $request)
  {
    $request->validate([
      'titulo'       => 'required',
      'descripcion'  => 'required:posts,descripcion',
      'fecha_inicio' => 'required|date|before_or_equal:fecha_final',
      'fecha_final'  => 'required|date|after_or_equal:fecha_inicio',
    ],[
        'titulo.required'              => 'Este campo es requerido',
        'descripcion.required'         => 'Este campo es requerido',
        'fecha_inicio.required'        => 'Este campo es Requerido',
        'fecha_final.required'         => 'Este campo es Requerido',
        'fecha_inicio.before_or_equal' => 'La fecha de inicio debe ser mayor o igual que la fecha final.',
        'fecha_final.after_or_equal'   => 'La fecha final debe ser menor o igual que la fecha de inicio.',
    ]);
    // Crea la proyecto
    $proyecto               = new Proyecto();
    $proyecto->titulo       = $request->input('titulo');
    $proyecto->descripcion  = $request->input('descripcion');
    $proyecto->fecha_inicio = $request->input('fecha_inicio');
    $proyecto->fecha_final  = $request->input('fecha_final');
    $proyecto->estado       = '1';
    $proyecto->save();
    // Devuelve el proyecto creada
    if ($request->is('api/*'))
      return response()->json($proyecto);
    else
      return redirect()->route('proyectos');
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
