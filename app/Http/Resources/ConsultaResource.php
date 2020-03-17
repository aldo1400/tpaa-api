<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConsultaResource extends JsonResource
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
            'texto' => $this->texto,
            'colaborador' => new ColaboradorResource($this->colaborador),
            'tipoConsulta' => new TipoConsultaResource($this->tipoConsulta),
        ];
    }
}
