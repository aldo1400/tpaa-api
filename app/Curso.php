<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Curso extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'interno',
    ];

    public function capacitaciones(): HasMany
    {
        return $this->hasMany('App\Capacitacion');
    }
}
