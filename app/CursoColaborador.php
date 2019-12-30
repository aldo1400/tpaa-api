<?php

namespace App;

use App\Http\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CursoColaborador extends Model
{
    // use ImageTrait; 
      /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cursos_colaborador';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'diploma',
        'tipo_archivo',
        'fecha',
        'estado',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha',
        'deleted_at',
    ];

    /**
     * Get the supervisor for the cargo.
     */
    public function colaborador(): BelongsTo
    {
        return $this->belongsTo('App\Colaborador');
    }

    /**
     * Get the supervisor for the cargo.
     */
    public function curso(): BelongsTo
    {
        return $this->belongsTo('App\Curso');
    }
}
