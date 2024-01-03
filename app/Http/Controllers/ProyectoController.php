<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proyecto;
use App\Models\Tarea;
use Carbon\Carbon;

class ProyectoController extends Controller {
    public function index() {
        // Lógica para mostrar una lista de proyectos
        $proyectos = Proyecto::all();
        // Devuelve la tarea creada
        return response()->json($proyectos);
    }

    public function show(int $id) {
        // Lógica para mostrar información detallada de un proyecto específico
        try {
            $proyecto = Proyecto::find($id);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "error" => "El proyecto no existe.",
                "code" => 404,
            ], 404);
        }
        // Devuelve la tarea creada
        return response()->json($proyecto);
    }

    public function edit(Request $request, int $id) {
        // Lógica para editar un proyecto en la base de datos
        $proyecto = Proyecto::findOrFail($id);

        $proyecto->titulo      = $request->input('titulo');
        $proyecto->descripcion = $request->input('descripcion');
        $proyecto->fecha_inicio = $request->input('fecha_inicio');
        $proyecto->fecha_final = $request->input('fecha_final');

        $proyecto->save();
        
        return response()->json($proyecto);
    }
    // consulta las tareas y el proyecto relacionado
    public function tareas(int $id)
    {
        $proyecto = Proyecto::find($id);

        $tareas = $proyecto->tareas;

        return response()->json([
            'proyecto' => $proyecto,
            'tareas' => $tareas
        ]);
    }
    // crea el proyecto
    public function crear(Request $request)
    {
        // Crea la tarea
        $proyecto = new Proyecto();
        $proyecto->titulo = $request->input('titulo');
        $proyecto->descripcion = $request->input('descripcion');
        $proyecto->fecha_inicio = $request->input('fecha_inicio');
        $proyecto->fecha_final = $request->input('fecha_final');
        $proyecto->estado = 1;

        $proyecto->save();

        // Devuelve la tarea creada
        return response()->json($proyecto);
    }
}
