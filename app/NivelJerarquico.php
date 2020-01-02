<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NivelJerarquico extends Model
{
     /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'niveles_jerarquico';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nivel_nombre',
        'estado'
    ];
}
