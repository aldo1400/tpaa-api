<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Colaborador extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'colaboradores';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut',
        'usuario',
        'password',
        'nombres',
        'apellidos',
        'sexo',
        'nacionalidad',
        'estado_civil',
        'fecha_nacimiento',
        'edad',
        'email',
        'nivel_educacion',
        'domicilio',
        'licencia_b',
        'vencimiento_licencia_b',
        'licencia_d',
        'vencimiento_licencia_d',
        'carnet_portuario',
        'vencimiento_carnet_portuario',
        'talla_calzado',
        'talla_chaleco',
        'talla_polera',
        'talla_pantalon',
        'fecha_ingreso',
        'telefono',
        'celular',
        'anexo',
        'contacto_emergencia_nombre',
        'contacto_emergencia_telefono',
        'estado',
        'fecha_inactividad',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'fecha_nacimiento',
        'vencimiento_licencia_b',
        'vencimiento_licencia_d',
        'vencimiento_carnet_portuario',
        'fecha_ingreso',
        'fecha_inactividad',
        'deleted_at',
    ];

    /**
     * Get the father for the departamento.
     */
    public function gerencia(): BelongsTo
    {
        return $this->belongsTo('App\Departamento', 'gerencia_id');
    }

    /**
     * Get the father for the departamento.
     */
    public function subgerencia(): BelongsTo
    {
        return $this->belongsTo('App\Departamento', 'subgerencia_id');
    }

    /**
     * Get the father for the departamento.
     */
    public function area(): BelongsTo
    {
        return $this->belongsTo('App\Departamento', 'area_id');
    }

    /**
     * Get the father for the departamento.
     */
    public function subarea(): BelongsTo
    {
        return $this->belongsTo('App\Departamento', 'subarea_id');
    }
}
