<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Proyecto;
use App\Models\Tarea;

class TareaController extends Controller
{
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
