<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movilidad extends Model
{
    use SoftDeletes;

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

    /**
     * Get the estado civil for the colaborador.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }

    /**
     * Get the estado civil for the colaborador.
     */
    public function cargo(): BelongsTo
    {
        return $this->belongsTo('App\Cargo');
    }

    /**
     * Get the tipo  for the movilidad.
     */
    public function tipoMovilidad(): BelongsTo
    {
        return $this->belongsTo('App\TipoMovilidad');
    }
}
