<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NivelEducacion extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'niveles_educacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nivel_tipo',
        'estado',
    ];

    public function colaboradores(): HasMany
    {
        return $this->hasMany('App\Colaborador');
    }
}
