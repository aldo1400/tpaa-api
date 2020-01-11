<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    const POSITIVO='POSITIVO';
    const NEGATIVO='NEGATIVO';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'permisos',
        'estado',
        'tipo',
    ];

    /**
     * The users that belong to the role.
     */
    public function colaboradores(): BelongsToMany
    {
        return $this->belongsToMany('App\Colaborador')
                    ->withPivot('estado')
                    ->withTimestamps();
    }
}
