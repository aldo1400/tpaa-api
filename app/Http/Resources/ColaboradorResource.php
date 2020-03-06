<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColaboradorResource extends JsonResource
{
    /**
     * @var
     */
    private $tagsCompletos;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     */
    public function __construct($resource, $tags)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;

        $this->tagsCompletos = $tags;
        // dd($this->tagsCompletos);
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'rut' => $this->rut,
            'nombre_completo' => $this->rut.' '.$this->primer_nombre.' '.$this->apellido_paterno.' '.$this->apellido_materno,
            'usuario' => $this->usuario ? $this->usuario : '',
            'primer_nombre' => $this->primer_nombre ? $this->primer_nombre : '',
            'segundo_nombre' => $this->segundo_nombre ? $this->segundo_nombre : '',
            'apellido_paterno' => $this->apellido_paterno ? $this->apellido_paterno : '',
            'apellido_materno' => $this->apellido_materno ? $this->apellido_materno : '',
            'imagen_url' => $this->imagen_url ? $this->imagen_url : '',
            'sexo' => $this->sexo ? $this->sexo : '',
            'nacionalidad' => $this->nacionalidad ? $this->nacionalidad : '',
            'fecha_nacimiento' => $this->fecha_nacimiento ? $this->fecha_nacimiento->format('Y-m-d') : '',
            'edad_colaborador' => $this->fecha_nacimiento ? $this->edad_colaborador : '',
            'email' => $this->email ? $this->email : '',
            'domicilio' => $this->domicilio ? $this->domicilio : '',
            'licencia_b' => $this->licencia_b ? $this->licencia_b : '',
            'vencimiento_licencia_b' => $this->vencimiento_licencia_b ? $this->vencimiento_licencia_b->format('Y-m-d') : '',
            'licencia_d' => $this->licencia_d ? $this->licencia_d : '',
            'vencimiento_licencia_d' => $this->vencimiento_licencia_d ? $this->vencimiento_licencia_d->format('Y-m-d') : '',
            'carnet_portuario' => $this->carnet_portuario ? $this->carnet_portuario : '',
            'vencimiento_carnet_portuario' => $this->vencimiento_carnet_portuario ? $this->vencimiento_carnet_portuario->format('Y-m-d') : '',
            'talla_calzado' => $this->talla_calzado ? $this->talla_calzado : '',
            'talla_chaleco' => $this->talla_chaleco ? $this->talla_chaleco : '',
            'talla_polera' => $this->talla_polera ? $this->talla_polera : '',
            'talla_pantalon' => $this->talla_pantalon ? $this->talla_pantalon : '',
            'fecha_ingreso' => $this->fecha_ingreso ? $this->fecha_ingreso->format('Y-m-d') : '',
            'telefono' => $this->telefono ? $this->telefono : '',
            'celular' => $this->celular ? $this->celular : '',
            'anexo' => $this->anexo ? $this->anexo : '',
            'contacto_emergencia_nombre' => $this->contacto_emergencia_nombre ? $this->contacto_emergencia_nombre : '',
            'contacto_emergencia_telefono' => $this->contacto_emergencia_telefono ? $this->contacto_emergencia_telefono : '',
            // 'estado' => $this->estado,
            'fecha_inactividad' => $this->fecha_inactividad ? $this->fecha_inactividad->format('Y-m-d') : '',
            'nivelEducacion' => $this->nivelEducacion ? new NivelEducacionResource($this->nivelEducacion) : '',
            'estadoCivil' => $this->estadoCivil ? new EstadoCivilResource($this->estadoCivil) : '',
            'tags' => $this->tagsCompletos ? TagResource::collection($this->tags) : TagResource::collection($this->tags)->pluck('id')->toArray(),
            'cargoActual' => $this->cargoActual() ? new CargoResource($this->cargoActual()) : '',
            'movilidadActual' => $this->movilidadActual() ? new MovilidadResource($this->movilidadActual()) : '',
            'credencial_vigilante' => $this->credencial_vigilante ? $this->credencial_vigilante : '',
            'vencimiento_credencial_vigilante' => $this->vencimiento_credencial_vigilante ? $this->vencimiento_credencial_vigilante->format('Y-m-d') : '',
        ];
    }
}
