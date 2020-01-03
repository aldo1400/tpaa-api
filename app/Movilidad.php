<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movilidad extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'movilidades';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha_inicio',
        'fecha_termino',
        'tipo',
        'observaciones',
        'estado',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha_inicio',
        'fecha_termino',
        'deleted_at',
    ];
}
