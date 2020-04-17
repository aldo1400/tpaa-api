<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ResultadoAreaResource extends JsonResource
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
            'resultado' => $this->resultado,
            'periodo' => new PeriodoResource($this->periodo),
            'area' => new AreaResource($this->area),
        ];
    }
}
