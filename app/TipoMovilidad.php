<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoMovilidad extends Model
{
    const NUEVO = 'Nuevo (a)';
    const MOVILIDAD = 'Movilidad';
    const DESARROLLO = 'Desarrollo';
    const DESVINCULADO = 'Desvinculado (a)';
    const RENUNCIA = 'Renuncia';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tipo_movilidades';

    public function movilidades(): HasMany
    {
        return $this->hasMany('App\Movilidad');
    }
}
