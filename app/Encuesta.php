<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Encuesta extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
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
     * Get the periodo that owns the encuesta.
     */
    public function periodo(): BelongsTo
    {
        return $this->belongsTo('App\Periodo');
    }

    /**
     * The colaboradores that belong to the encuesta.
     */
    public function colaboradores(): BelongsToMany
    {
        return $this->belongsToMany('App\Colaborador')
                ->withPivot('estado', 'url')
                ->withTimestamps();
    }
}
