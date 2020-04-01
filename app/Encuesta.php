<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Encuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'periodo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'encuesta_facil_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
    ];

    /**
     * Get the encuesta plantilla that owns the encuesta.
     */
    public function encuestaPlantilla(): BelongsTo
    {
        return $this->belongsTo('App\EncuestaPlantilla');
    }
}
