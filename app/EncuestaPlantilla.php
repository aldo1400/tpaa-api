<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EncuestaPlantilla extends Model
{
    const TOP = 'top';
    const DOWN = 'down';
    const PRIMER = 'primer';
    const SEGUNDO = 'segundo';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'evaluacion',
        'descripcion',
        'tipo_puntaje',
        'tiene_item',
        'numero_preguntas',
    ];

    public function encuestas(): HasMany
    {
        return $this->hasMany('App\Encuesta');
    }

    public function preguntas(): HasMany
    {
        return $this->hasMany('App\Pregunta');
    }
}
