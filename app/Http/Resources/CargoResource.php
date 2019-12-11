<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CargoResource extends JsonResource
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
            'nivel_jerarquico' => $this->nivel_jeraquico,
            'nombre' => $this->nombre,
            'supervisor_id' => $this->supervisor_id,
        ];
    }
}
