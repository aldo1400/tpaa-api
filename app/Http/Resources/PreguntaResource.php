<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PreguntaResource extends JsonResource
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
            'pregunta' => $this->pregunta,
            'tipo' => $this->tipo,
            'item' => $this->item,
            'encuestaPlantilla' => new EncuestaPlantillaResource($this->encuestaPlantilla),
        ];
    }
}
