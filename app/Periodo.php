<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Periodo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'year',
        'detalle',
        'descripcion',
        'publicado',
    ];

    /**
     * Get the encuesta plantilla that owns the periodo.
     */
    public function encuestaPlantilla(): BelongsTo
    {
        return $this->belongsTo('App\EncuestaPlantilla');
    }

    public function encuestas(): HasMany
    {
        return $this->hasMany('App\Encuesta');
    }

    public function encuestasRelacionadas()
    {
        return $this->encuestas->count();
    }
}
