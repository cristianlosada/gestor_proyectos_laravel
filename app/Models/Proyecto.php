<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Validator;

use Illuminate\Database\Eloquent\Model;

class Proyecto extends Model
{
    use HasFactory;
    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_final',
        'estado',
    ];
    public function tareas()
    {
        return $this->hasMany(Tarea::class);
    }
    /**
     * Metodo que valida los filtros y ordenamiendo de busquedas
     */
    public function validador_filtros($request) {
        $validator = Validator::make($request, [
            'orderBy'            => ['required'],
            'orderDirection'     => ['required'],
            'filters'            => ['required'],
            'filters.*.field'    => ['required', 'min:1'],
            'filters.*.operator' => ['required'],
            'filters.*.value'    => ['required']
        ]);
        $validator->setCustomMessages([
            'orderBy.required'            => 'El order son obligatorios.',
            'orderDirection.required'     => 'Los la direccion del orden son obligatorios.',
            'filters.required'            => 'Los filtros son obligatorios.',
            'filters.*.field.required'    => 'El valor del field es obligatorio',
            'filters.*.operator.required' => 'El valor del operator es obligatorio.',
            'filters.*.value.required'    => 'El valor del value es obligatorio',
        ]);
        $resultado = '';
        if ($validator->fails())
            $resultado = $validator->errors();
        return $resultado;
    }
}
