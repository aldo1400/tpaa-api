<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cargo extends Model
{
    use SoftDeletes;

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
     * Get the supervisor for the cargo.
     */
    public function supervisor(): BelongsTo
    {
        return $this->belongsTo('App\Cargo', 'supervisor_id');
    }

    /**
     * Get the area for the cargo.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo('App\Area');
    }

    /**
     * Get the nivel jerarquico for the cargo.
     */
    public function nivelJerarquico(): BelongsTo
    {
        return $this->belongsTo('App\NivelJerarquico');
    }

    /**
     * Get the nivel jerarquico for the cargo.
     */
    public function movilidades(): HasMany
    {
        return $this->HasMany('App\Movilidad');
    }

    public function encontrarCargoInferior()
    {
        $cargosHijos=self::where('supervisor_id', $this->id)->get();
        if($cargosHijos->where('estado',1)->count()){
            return true;
        }

        return false;
    }
}
