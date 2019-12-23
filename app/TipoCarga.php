<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoCarga extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo',
        'estado',
    ];

    public function cargasFamiliares(): HasMany
    {
        return $this->hasMany('App\CargaFamiliar');
    }
}
