<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comentario extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'texto_libre',
        'publico',
        'fecha',
        'estado',
        'positivo'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['fecha'];

    public function tipoComentario(): BelongsTo
    {
        return $this->belongsTo('App\TipoComentario');
    }

    public function receptor(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador', 'colaborador_id');
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador', 'colaborador_autor_id');
    }
}
