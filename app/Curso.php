<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Curso extends Model
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'titulo',
        'horas_cronologicas',
        'realizado',
        'fecha_inicio',
        'fecha_termino',
        'estado',
        'anio',
        'interno',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'deleted_at',
        'fecha_inicio',
        'fecha_termino',
    ];

    public function colaboradores(): HasMany
    {
        return $this->hasMany('App\CursoColaborador');
    }

    /**
     * Get the tipo for the cursp.
     */
    public function tipoCurso(): BelongsTo
    {
        return $this->belongsTo('App\TipoCurso');
    }

    public function guardarColaboradores()
    {
    }

    public function saveFile($file)
    {
        $filePath = $file->storeAs(
                    'public/diplomas',
                    $this->id.'_'.$this->nombre.'.'.$file->extension()
                );

        return $filePath;
    }
}
