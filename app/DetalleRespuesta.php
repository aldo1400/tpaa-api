<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    protected $appends = ['promedio'];

    public function clienteInternoPromedio()
    {
        $respuestas = $this->respuestas;
        $suma = 0;
        foreach ($respuestas as $respuesta) {
            if ($respuesta->valor_respuesta) {
                $suma = $suma + $respuesta->valor_respuesta;
            }
        }

        return ($suma / 10) * 100;
    }

    public function encuestaClimaPromedio()
    {
        $respuestas = $this->respuestas;
        $suma = 0;
        $promedioTotal = 0;
        // TO DO Mejorar algoritmo
        for ($i = 1; $i < 23; ++$i) {
            $suma = 0;
            $numeroRespuestas = 0;
            foreach ($respuestas as $respuesta) {
                if ($respuesta->valor_respuesta && $respuesta->pregunta->item == $i) {
                    $suma = $suma + $respuesta->valor_respuesta;
                    $numeroRespuestas = $numeroRespuestas + 1;
                }
            }

            $promedio = $suma / $numeroRespuestas;

            $promedioTotal = $promedio + $promedioTotal;
        }

        return ($promedioTotal / 22) * 100;
    }

    public function getPromedioAttribute()
    {
        switch ($this->encuesta->periodo->encuestaPlantilla->id) {
            case 1:
                $promedio = $this->clienteInternoPromedio();
                break;
            case 2:

                $promedio = $this->encuestaClimaPromedio();
                break;
            default:
                $promedio = 0;
                break;
        }

        return $promedio;
    }

    /**
     * Get the estado civil for the colaborador.
     */
    public function encuesta(): BelongsTo
    {
        return $this->belongsTo('App\Encuesta');
    }

    /**
     * The colaboradores that belong to the encuesta.
     */
    public function respuestas(): HasMany
    {
        return $this->hasMany('App\Respuesta');
    }
}
