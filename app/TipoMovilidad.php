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
    const TERMINO_DE_CONTRATO = 'Termino de contrato';

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

    public function isNuevo(): bool
    {
        return $this->tipo === TipoMovilidad::NUEVO;
    }

    public function isRenuncia(): bool
    {
        return $this->tipo === TipoMovilidad::RENUNCIA;
    }

    public function isDesvinculado(): bool
    {
        return $this->tipo === TipoMovilidad::DESVINCULADO;
    }

    public function isTerminoDeContrato(): bool
    {
        return $this->tipo === TipoMovilidad::TERMINO_DE_CONTRATO;
    }

    public function isExcluyente(): bool
    {
        if ($this->isRenuncia()) {
            return true;
        }

        if ($this->isDesvinculado()) {
            return true;
        }

        if ($this->isTerminoDeContrato()) {
            return true;
        }

        return false;
    }
}
