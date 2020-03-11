<?php

namespace App;

use Carbon\Carbon;
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

    public function isRenuncia(): bool
    {
        return $this->tipoMovilidad->tipo === TipoMovilidad::RENUNCIA;
    }

    public function isDesvinculado(): bool
    {
        return $this->tipoMovilidad->tipo === TipoMovilidad::DESVINCULADO;
    }

    public function isTerminoDeContrato(): bool
    {
        return $this->tipoMovilidad->tipo === TipoMovilidad::TERMINO_DE_CONTRATO;
    }

    public function isTipoExcluyente(): bool
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

    public function isActivo(): bool
    {
        return $this->estado === 1;
    }

    public function validarNuevasFechas($fecha_inicio, $fecha_termino)
    {
        $movilidades = self::where('id', '!=', $this->id)->get();

        if ($this->isActivo()) {
            $movilidadPenultima = $movilidades
            ->sortByDesc('id')
            ->first();

            if (!$movilidadPenultima) {
                return true;
            }

            if (Carbon::parse($movilidadPenultima->fecha_termino)->lt(Carbon::parse($fecha_inicio))) {
                return true;
            }

            return false;
        }

        $checkDate = true;
        foreach ($movilidades as $movilidad) {
            if ($movilidad->isActivo()) {
                if (Carbon::parse($movilidad->fecha_inicio)->lt(Carbon::parse($fecha_termino))) {
                    $checkDate = false;
                    break;
                }
                continue;
            }
            $check = Carbon::parse($fecha_inicio)->between(Carbon::parse($movilidad->fecha_inicio), Carbon::parse($movilidad->fecha_termino));
            if ($check) {
                $checkDate = false;
                break;
            }

            $checkTwo = Carbon::parse($fecha_termino)->between(Carbon::parse($movilidad->fecha_inicio), Carbon::parse($movilidad->fecha_termino));
            if ($checkTwo) {
                $checkDate = false;
                break;
            }

            $checkThree = Carbon::parse($movilidad->fecha_inicio)->between(Carbon::parse($fecha_inicio), Carbon::parse($fecha_termino));
            if ($checkThree) {
                $checkDate = false;
                break;
            }
        }

        return $checkDate;
    }
}
