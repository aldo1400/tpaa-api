<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cargo extends Model
{
    use SoftDeletes;

    const ESTRATEGICO_TACTICO = 'Estratégico Táctico';
    const OPERATIVO_SUPERVISIÓN = 'Operativo Supervisión';
    const TACTICO_OPERATIVO = 'Táctico Operativo';
    const TACTICO = 'Táctico';
    const EJECUCION = 'Ejecución';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nivel_jerarquico',
        'nombre',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the supervisor for the cargo.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo('App\Cargo', 'supervisor_id');
    }

    public function encontrarCargoInferior()
    {
        if (self::where('supervisor_id', $this->id)->first()) {
            return true;
        }

        return false;
    }
}
