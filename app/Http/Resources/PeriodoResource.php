<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PeriodoResource extends JsonResource
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
            'nombre' => $this->nombre,
            'year' => $this->year,
            'detalle' => $this->detalle,
            'descripcion' => $this->descripcion,
            'encuestaPlantilla' => new EncuestaPlantillaResource($this->encuestaPlantilla),
            'encuestas' => $this->encuestasRelacionadas() ? true : false,
        ];
    }
}
