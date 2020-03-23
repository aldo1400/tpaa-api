<?php

namespace App;

use Carbon\Carbon;
use App\Helpers\Image;
use App\Http\Traits\DateTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Colaborador extends Authenticatable implements JWTSubject
{
    use DateTrait;
    const DESVINCULADO = 'Desvinculado (a)';
    const RENUNCIA = 'Renuncia';
    const ACTIVO = 'Activo (a)';

    protected $guard = 'colaboradores';
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'colaboradores';

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

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
        // 'imagen',
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

    public function consultas(): HasMany
    {
        return $this->hasMany('App\Consulta');
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

    public function notificaciones(): HasMany
    {
        return $this->hasMany('App\Notificacion');
    }

    public function comentariosRecibidos(): HasMany
    {
        return $this->hasMany('App\Comentario', 'colaborador_id');
    }

    public function setImagenAttribute($imagen)
    {
        $this->attributes['imagen'] = $imagen ? is_string($imagen) ? base64_encode($imagen) : Image::convertImage($imagen) : '';
    }

    public function tieneMovilidades(): bool
    {
        return $this->movilidades()->count();
    }

    public function obtenerFechaDeIngreso()
    {
        if (!$this->tieneMovilidades()) {
            return null;
        }

        $movilidad = $this->movilidades()
                        ->whereHas('tipoMovilidad', function ($query) {
                            $query->where('tipo', TipoMovilidad::NUEVO);
                        })
                        ->orderBy('fecha_inicio', 'desc')
                        ->first();

        if ($movilidad) {
            return $movilidad->fecha_inicio->format('Y-m-d');
        }

        $primeraMovilidad = $this->movilidades
                            ->sortBy('fecha_inicio')
                            ->first();

        return $primeraMovilidad->fecha_inicio->format('Y-m-d');
    }

    public function actualizarEstadoSegunMovilidad($movilidad)
    {
        if (!$this->movilidades->count()) {
            $this->update([
                'estado' => 0,
            ]);

            return true;
        }

        if ($movilidad->isTipoExcluyente()) {
            $this->update([
                'estado' => 0,
            ]);

            return true;
        }

        $this->update([
            'estado' => 1,
        ]);

        return true;
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
            return $movilidad->cargo;
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

    public function obtenerURLPublicaDeImagenColaborador()
    {
        $ext = pathinfo($this->imagen_url, PATHINFO_EXTENSION);
        if ($ext) {
            $url = 'public/colaboradores/imagenes/'.$this->rut.'.'.$ext;
        } else {
            $url = 'public/colaboradores/imagenes/'.$this->rut.'.jpg';
        }

        return $url;
    }

    public function actualizarArchivo($request, $tipo)
    {
        $tipoUrl = 'url_'.$tipo;

        if ($request->file($tipo)) {
            $this->$tipoUrl = $this->saveFile($request->file($tipo), $tipo);
        } else {
            if (!$request->$tipoUrl && $this->$tipoUrl) {
                Storage::delete($this->$tipoUrl);
                $this->$tipo = null;
                $this->$tipoUrl = null;
            }
        }
    }

    public function generarImagen()
    {
        if ($this->imagen) {
            if (!(Storage::disk('local')->exists($this->imagen_url))) {
                $url = $this->obtenerURLPublicaDeImagenColaborador();

                Storage::disk('local')
                        ->put($url, base64_decode($this->imagen));

                $this->update([
                    'imagen_url' => url(Storage::url($url)),
                ]);
            }
        } else {
            if ($this->imagen_url) {
                $url = $this->obtenerURLPublicaDeImagenColaborador();

                $content = Storage::get($url);

                if ($content) {
                    $this->imagen = $content;
                    $this->save();
                }

                return true;
            }
        }
    }

    public function revisarFechaVencimiento($tipo)
    {
        $now = Carbon::now();
        if ($this->$tipo) {
            if ($this->$tipo->diffInDays($now) < Notificacion::DIAS_LIMITE) {
                $tipoCorto = str_replace('vencimiento_', '', $tipo);

                $notificaciones = $this->notificaciones()
                        ->where('tipo', $tipoCorto)
                        ->get()
                        ->count();

                if (!$notificaciones) {
                    $tipoSeparado = ucwords(str_replace('_', ' ', $tipoCorto));

                    // dd($tipo);
                    $mensaje = 'Su '.$tipoSeparado.' vencerá el '.$this->$tipo->format('d-m-Y').'.';
                    $notificacion = Notificacion::make([
                        'mensaje' => $mensaje,
                        'tipo' => $tipoCorto,
                    ]);
                    $notificacion->colaborador()->associate($this);
                    $notificacion->save();
                }
            }
        }
    }

    public function actualizarFechaVencimiento($tipo)
    {
        $now = Carbon::now();
        if ($this->$tipo) {
            if ($this->$tipo->diffInDays($now) > Notificacion::DIAS_LIMITE) {
                $tipo = str_replace('vencimiento_', '', $tipo);
                $notificacion = $this->notificaciones()
                            ->where('tipo', $tipo)
                            ->first();

                if ($notificacion) {
                    $notificacion->delete();
                }
            }
        }

        return true;
    }
}
