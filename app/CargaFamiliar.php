<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CargaFamiliar extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cargas_familiares';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut',
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'estado',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'fecha_nacimiento',
    ];

    /**
     * Get the supervisor for the cargo.
     */
    public function tipoCarga(): BelongsTo
    {
        return $this->belongsTo('App\TipoCarga');
    }

    /**
     * Get the supervisor for the cargo.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }
}
