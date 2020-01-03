<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoArea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo_nombre',
        // 'nivel',
        'estado',
    ];

    public function nuevoNivel()
    {
        return self::latest()->first()->nivel+1;
    }
}
