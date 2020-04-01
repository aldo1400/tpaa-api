<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pregunta extends Model
{
    const ALTERNATIVA = 'Alternativa';
    const ABIERTA = 'Abierta';
    const CERRADA = 'Cerrada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pregunta',
        'tipo',
        'item',
    ];

    public function encuestaPlantilla(): BelongsTo
    {
        return $this->belongsTo('App\EncuestaPlantilla');
    }
}
