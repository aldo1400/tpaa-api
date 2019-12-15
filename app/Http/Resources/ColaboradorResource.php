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
            'nombres' => $this->nombres,
            'apellidos' => $this->apellidos,
            'sexo' => $this->sexo,
            'nacionalidad' => $this->nacionalidad,
            'estado_civil' => $this->estado_civil,
            'fecha_nacimiento' => $this->fecha_nacimiento->format('Y-m-d'),
            'edad' => $this->edad,
            'email' => $this->email,
            'nivel_educacion' => $this->nivel_educacion,
            'domicilio' => $this->domicilio,
            'licencia_b' => $this->licencia_b,
            'vencimiento_licencia_b' => $this->vencimiento_licencia_b,
            'licencia_d' => $this->licencia_d,
            'vencimiento_licencia_d' => $this->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $this->carnet_portuario,
            'vencimiento_carnet_portuario' => $this->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $this->talla_calzado,
            'talla_chaleco' => $this->talla_chaleco,
            'talla_polera' => $this->talla_polera,
            'talla_pantalon' => $this->talla_pantalon,
            'fecha_ingreso' => $this->fecha_ingreso->format('d-m-Y'),
            'telefono' => $this->telefono,
            'celular' => $this->celular,
            'anexo' => $this->anexo,
            'contacto_emergencia_nombre' => $this->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $this->contacto_emergencia_telefono,
            'estado' => $this->estado,
            'fecha_inactividad' => $this->fecha_inactividad->format('d-m-Y'),
        ];
    }
}
