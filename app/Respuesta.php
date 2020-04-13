<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resultado',
        'valor_respuesta',
        'detalle_respuesta_id',
        'pregunta_id',
    ];
}
