<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovilidadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'=>$this->id,
            'fecha_inicio'=>$this->fecha_inicio->format('Y-m-d'),
            'fecha_termino'=>$this->fecha_termino ? $this->fecha_termino->format('Y-m-d') : '',
            'tipo'=>$this->tipo,
            'observaciones'=>$this->observaciones,
            'estado'=>$this->estado,
            'cargo_id'=>$this->cargo_id,
            'colaborador_id'=>$this->colaborador_id
        ];
    }
}
