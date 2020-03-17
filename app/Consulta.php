<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consulta extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'texto',
    ];

    /**
     * Get the tipo for the cursp.
     */
    public function tipoConsulta(): BelongsTo
    {
        return $this->belongsTo('App\TipoConsulta');
    }

    /**
     * Get the tipo for the cursp.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }
}
