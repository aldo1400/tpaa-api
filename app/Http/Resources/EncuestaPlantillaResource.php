<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EncuestaPlantillaResource extends JsonResource
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
            'evaluacion' => $this->evaluacion,
            'descripcion' => $this->descripcion,
            'tipo_puntaje' => $this->tipo_puntaje,
            'tiene_item' => $this->tiene_item,
            'numero_preguntas' => $this->numero_preguntas,
        ];
    }
}
