<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use App\Models\Proyecto;

class tarea extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'estado',
        'proyecto_id',
    ];
    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }
    /**
     * Metodo que valida los filtros y ordenamiendo de busquedas
     */
    public function validador_tarea($request) {
        $validator = Validator::make($request, [
            'titulo'       => ['required'],
            'descripcion'  => ['required'],
            'estado_tarea' => ['required']
        ]);
        $validator->setCustomMessages([
            'titulo'       => 'el titulo es obligatorio.',
            'descripcion'  => 'el descripcion es obligatorio.',
            'estado_tarea' => 'el estado es obligatorio.'
        ]);
        $resultado = '';
        if ($validator->fails())
            $resultado = $validator->errors();
        return $resultado;
    }
}
