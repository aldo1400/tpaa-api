<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Departamento extends Model
{
    use SoftDeletes;

    const GERENCIA_GENERAL = 'Gerencia General';
    const GERENCIA = 'Gerencia';
    const SUBGERENCIA = 'Subgerencia';
    const AREA = 'Área';
    const SUBAREA = 'Subarea';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'tipo',
        'nombre',
        'estado',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the father for the departamento.
     */
    public function padre(): BelongsTo
    {
        return $this->belongsTo('App\Departamento', 'padre_id');
    }

    /**
     * Get the tipo for area.
     */
    public function tipoArea(): BelongsTo
    {
        return $this->belongsTo('App\TipoArea');
    }

    public function encontrarDepartamentoInferior()
    {
        if (self::where('padre_id', $this->id)->first()) {
            return true;
        }

        return false;
    }
}
