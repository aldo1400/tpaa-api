<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultadoArea extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'resultado',
    ];

    /**
     * Get the father for the departamento.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo('App\Area');
    }

    /**
     * Get the father for the departamento.
     */
    public function periodo(): BelongsTo
    {
        return $this->belongsTo('App\Periodo');
    }
}
