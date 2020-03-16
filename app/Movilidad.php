<?php

namespace App;

use Carbon\Carbon;
use App\Http\Traits\DateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Movilidad extends Model
{
    use SoftDeletes;
    use DateTrait;
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

    public function isTipoRenuncia(): bool
    {
        return $this->tipoMovilidad->isRenuncia();
    }

    public function isTipoDesvinculado(): bool
    {
        return $this->tipoMovilidad->isDesvinculado();
    }

    public function isTipoTerminoDeContrato(): bool
    {
        return $this->tipoMovilidad->isTerminoDeContrato();
    }

    public function isTipoExcluyente(): bool
    {
        if ($this->isTipoRenuncia()) {
            return true;
        }

        if ($this->isTipoDesvinculado()) {
            return true;
        }

        if ($this->isTipoTerminoDeContrato()) {
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
        $colaborador = $this->colaborador;
        $movilidades = $colaborador->movilidades
                        ->where('id', '!=', $this->id);

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

        $checkDate = $this->validarLimitesDeFecha($movilidades, $fecha_inicio, $fecha_termino);

        return $checkDate;
    }
}
