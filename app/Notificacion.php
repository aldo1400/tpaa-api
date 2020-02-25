<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notificacion extends Model
{
    const ENCUESTA = 'encuesta';
    const LICENCIA = 'licencia';
    const LICENCIA_B = 'licencia_b';
    const LICENCIA_D = 'licencia_d';
    const CARNET = 'carnet_portuario';
    const CREDENCIAL = 'credencial_vigilante';
    const DIAS_LIMITE = '45';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notificaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mensaje',
        'tipo',
    ];

    /**
     * Get the tipo for the cursp.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }
}
