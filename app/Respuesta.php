<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * Get the estado civil for the colaborador.
     */
    public function detalleRespuesta(): BelongsTo
    {
        return $this->belongsTo('App\DetalleRespuesta');
    }

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo('App\Pregunta');
    }
}
