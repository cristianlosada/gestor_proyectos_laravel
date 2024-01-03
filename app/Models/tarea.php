<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;
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
}
