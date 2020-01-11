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
    ];

    public function tipoComentario(): BelongsTo
    {
        return $this->belongsTo('App\TipoComentario');
    }

    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }

    public function autor(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador', 'colaborador_autor_id');
    }
}
