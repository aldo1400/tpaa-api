<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TipoCurso extends Model
{
      /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'categoria',
        'estado'
    ];

    public function cursos(): HasMany
    {
        return $this->hasMany('App\Curso');
    }
}
