<?php

namespace App;

use Carbon\Carbon;
use App\Helpers\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Colaborador extends Model
{
    const DESVINCULADO = 'Desvinculado (a)';
    const RENUNCIA = 'Renuncia';
    const ACTIVO = 'Activo (a)';

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
        'usuario',
        'password',
        'primer_nombre',
        'segundo_nombre',
        'apellido_paterno',
        'apellido_materno',
        'imagen',
        'sexo',
        'nacionalidad',
        'fecha_nacimiento',
        'edad',
        'email',
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
        'credencial_vigilante',
        'vencimiento_credencial_vigilante',
        'imagen_url',
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
        'vencimiento_credencial_vigilante',
    ];

    protected $appends = ['edad_colaborador'];

    public function getEdadColaboradorAttribute()
    {
        $now = Carbon::now();

        $age = $now->diffInYears($this->fecha_nacimiento);

        return $age;
    }

    /**
     * Get the estado civil for the colaborador.
     */
    public function estadoCivil(): BelongsTo
    {
        return $this->belongsTo('App\EstadoCivil');
    }

    /**
     * Get the estado civil for the colaborador.
     */
    public function nivelEducacion(): BelongsTo
    {
        return $this->belongsTo('App\NivelEducacion');
    }

    public function cargasFamiliares(): HasMany
    {
        return $this->hasMany('App\CargaFamiliar');
    }

    public function capacitaciones(): HasMany
    {
        return $this->hasMany('App\CursoColaborador');
    }

    public function movilidades(): HasMany
    {
        return $this->hasMany('App\Movilidad');
    }

    public function setImagenAttribute($imagen)
    {
        $this->attributes['imagen'] = $imagen ? Image::convertImage($imagen) : '';
    }

    public function saveImage($request)
    {
        $imagePath = $request->file('imagen')
                ->storeAs(
                    'public/colaboradores/imagenes',
                    $this->rut.'.'.$request->file('imagen')->extension()
                );

        return url(Storage::url($imagePath));
    }

    /**
     * The roles that belong to the user.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')
                ->withPivot('estado')
                ->withTimestamps();
    }

    public function movilidadActual()
    {
        return $this->movilidades()
                ->where('estado', 1)
                ->first();
    }

    public function cargoActual()
    {
        $movilidad = $this->movilidades()
                ->where('estado', 1)
                ->first();

        if ($movilidad) {
            return $movilidad->cargo();
        }

        return $movilidad;
    }

    public function tagsPositivos()
    {
        return $this->tags()
                ->where('tags.estado', 1)
                ->where('tipo', 'POSITIVO')
                ->get();
    }

    public function obtenerTipoDepartamento()
    {
        $departamento = '';

        if ($this->gerencia) {
            $departamento = 'gerencia';
        }
        if ($this->subgerencia) {
            $departamento = 'subgerencia';
        }
        if ($this->area) {
            $departamento = 'area';
        }
        if ($this->subarea) {
            $departamento = 'subarea';
        }

        return $departamento;
    }

    public function definirDepartamento($departamento)
    {
        if ($departamento->tipo == Departamento::GERENCIA_GENERAL || $departamento->tipo == Departamento::GERENCIA) {
            $this->gerencia()->associate($departamento->id);
        } elseif ($departamento->tipo == Departamento::SUBGERENCIA) {
            $this->subgerencia()->associate($departamento->id);
        } elseif ($departamento->tipo == Departamento::AREA) {
            $this->area()->associate($departamento->id);
        } elseif ($departamento->tipo == Departamento::SUBAREA) {
            $this->subarea()->associate($departamento->id);
        } else {
        }

        return true;
    }
}
