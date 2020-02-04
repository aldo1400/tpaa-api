<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovilidadResource extends JsonResource
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
            'fecha_inicio' => $this->fecha_inicio->format('Y-m-d'),
            'fecha_termino' => $this->fecha_termino ? $this->fecha_termino->format('Y-m-d') : '',
            'observaciones' => $this->observaciones,
            'estado' => $this->estado,
            'cargo_id' => $this->cargo_id,
            'cargo_nombre' => $this->cargo ? $this->cargo->nombre : '',
            'colaborador_id' => $this->colaborador_id,
            'tipoMovilidad' => new TipoMovilidadResource($this->tipoMovilidad),
        ];
    }
}
