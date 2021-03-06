<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Area extends Model
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
        return $this->belongsTo('App\Area', 'padre_id');
    }

    public function cargos(): HasMany
    {
        return $this->hasMany('App\Cargo');
    }

    /**
     * Get the tipo for area.
     */
    public function tipoArea(): BelongsTo
    {
        return $this->belongsTo('App\TipoArea');
    }

    public function encontrarAreaInferior()
    {
        $areasHijos = self::where('padre_id', $this->id)->get();
        if ($areasHijos->where('estado', 1)->count()) {
            return true;
        }

        return false;
    }

    public function obtenerAreasRelacionadas()
    {
        $arregloAreas = collect();
        $areaEditar = Area::where('id', $this->id)->first();
        $padre_id = $areaEditar->padre_id;
        $padre = $areaEditar->padre;
        if ($padre_id != null) {
            $flag = 0;
        } else {
            $flag = 1;
        }

        while ($flag == 0) {
            if (isset($padre_id)) {
                $area = Area::with('tipoArea')->where('id', $padre_id)->first();
                $arregloAreas->push($area);
                $padre_id = $area->padre_id;
            } else {
                $flag = 1;
            }
        }

        return $arregloAreas;
    }
}
