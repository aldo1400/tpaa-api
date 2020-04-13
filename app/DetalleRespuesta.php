<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleRespuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'evaluador_id',
        'cargo_evaluador_id',
        'gerencia_evaluador_id',
        'subgerencia_evaluador_id',
        'area_evaluador_id',
        'subarea_evaluador_id',
        'evaluado_id',
        'cargo_evaluado_id',
        'gerencia_evaluado_id',
        'subgerencia_evaluado_id',
        'area_evaluado_id',
        'subarea_evaluado_id',
        'cargo_polifuncionalidad_id',
        'horas_turno_polifuncionalidad',
        'fecha',
        'encuesta_id',
        'cargo_id',
        'area_id',
        'tipo_area_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha',
    ];
}
