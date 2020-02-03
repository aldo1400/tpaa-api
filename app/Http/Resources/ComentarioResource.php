<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ComentarioResource extends JsonResource
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
        // dd(collect($this->receptor->only(['id', 'name', 'imagen'])));

        return [
            'id' => $this->id,
            'texto_libre' => $this->texto_libre,
            'publico' => $this->publico,
            'fecha' => $this->fecha->format('Y-m-d'),
            'estado' => $this->estado,
            'tipoComentario' => new TipoComentarioResource($this->tipoComentario),
            // 'receptor' => new ColaboradorResource($this->receptor),
            // 'autor'=>
        ];
    }
}
