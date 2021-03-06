<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificacionResource extends JsonResource
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
            'colaborador' => new ColaboradorResource($this->colaborador),
            'tipo' => $this->tipo,
            'tipoFormato' => ucwords(str_replace('_', ' ', $this->tipo)),
            'mensaje' => $this->mensaje,
            'updated_at' => $this->updated_at->format('Y-m-d'),
        ];
    }
}
