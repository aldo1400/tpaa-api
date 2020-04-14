<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ColaboradorShortResource extends JsonResource
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
            'nombre_completo' => $this->rut.' '.$this->primer_nombre.' '.$this->apellido_paterno.' '.$this->apellido_materno,
            'usuario' => $this->usuario ? $this->usuario : '',
            'primer_nombre' => $this->primer_nombre ? $this->primer_nombre : '',
            'segundo_nombre' => $this->segundo_nombre ? $this->segundo_nombre : '',
            'apellido_paterno' => $this->apellido_paterno ? $this->apellido_paterno : '',
            'apellido_materno' => $this->apellido_materno ? $this->apellido_materno : '',
            'imagen_url' => $this->imagen_url ? $this->imagen_url : '',
            'cargoActual' => $this->cargoActual() ? new CargoResource($this->cargoActual()) : '',
            'areaActual' => $this->cargoActual() ? new AreaResource($this->cargoActual()->area) : '',
        ];
    }
}
