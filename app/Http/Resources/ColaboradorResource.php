<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColaboradorResource extends JsonResource
{
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
            'usuario' => $this->usuario,
            'primer_nombre' => $this->primer_nombre,
            'segundo_nombre' => $this->segundo_nombre,
            'apellido_paterno' => $this->apellido_paterno,
            'apellido_materno' => $this->apellido_materno,
            'imagen' => $this->imagen,
            'sexo' => $this->sexo,
            'nacionalidad' => $this->nacionalidad,
            'fecha_nacimiento' => $this->fecha_nacimiento ? $this->fecha_nacimiento->format('d-m-Y') : '',
            'edad' => $this->edad,
            'email' => $this->email,
            'domicilio' => $this->domicilio,
            'licencia_b' => $this->licencia_b,
            'vencimiento_licencia_b' => $this->vencimiento_licencia_b ? $this->vencimiento_licencia_b->format('d-m-Y') : '',
            'licencia_d' => $this->licencia_d,
            'vencimiento_licencia_d' => $this->vencimiento_licencia_d ? $this->vencimiento_licencia_d->format('d-m-Y') : '',
            'carnet_portuario' => $this->carnet_portuario,
            'vencimiento_carnet_portuario' => $this->vencimiento_carnet_portuario ? $this->vencimiento_carnet_portuario->format('d-m-Y') : '',
            'talla_calzado' => $this->talla_calzado,
            'talla_chaleco' => $this->talla_chaleco,
            'talla_polera' => $this->talla_polera,
            'talla_pantalon' => $this->talla_pantalon,
            'fecha_ingreso' => $this->fecha_ingreso ? $this->fecha_ingreso->format('d-m-Y') : '',
            'telefono' => $this->telefono,
            'celular' => $this->celular,
            'anexo' => $this->anexo,
            'contacto_emergencia_nombre' => $this->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $this->contacto_emergencia_telefono,
            'estado' => $this->estado,
            'fecha_inactividad' => $this->fecha_inactividad ? $this->fecha_inactividad->format('d-m-Y') : '',
            'nivelEducacion' => new NivelEducacionResource($this->nivelEducacion),
            'estadoCivil' => new EstadoCivilResource($this->estadoCivil),
            'tags' => TagResource::collection($this->tags),
            'cargoActual' => $this->cargoActual() ? new CargoResource($this->cargoActual()) : '',
            'credencial_vigilante' => $this->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $this->vencimiento_credencial_vigilante ? $this->vencimiento_credencial_vigilante->format('d-m-Y') : '',
        ];
    }
}
