<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EstadoCivil extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'estado_civiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo',
        'estado',
    ];

    /**
     * Get the colaboradores for the estado civil.
     */
    public function colaboradores(): HasMany
    {
        return $this->hasMany('App\Colaborador');
    }
}
