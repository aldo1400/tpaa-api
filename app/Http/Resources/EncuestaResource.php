<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EncuestaResource extends JsonResource
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
            'periodo' => $this->periodo,
            'descripcion' => $this->descripcion,
            'fecha_inicio' => $this->fecha_inicio->format('Y-m-d'),
            'fecha_fin' => $this->fecha_fin->format('Y-m-d'),
            'encuesta_facil_id' => $this->encuesta_facil_id,
            'encuestaPlantilla' => new EncuestaPlantillaResource($this->encuestaPlantilla),
        ];
    }
}
