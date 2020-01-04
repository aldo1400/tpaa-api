<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AreaResource extends JsonResource
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
            'padre_id' => $this->padre_id,
            'estado' => $this->estado,
            'tipoArea' => new TipoAreaResource($this->tipoArea),
        ];
    }
}
