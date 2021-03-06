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
        return [
            'id' => $this->id,
            'texto_libre' => $this->texto_libre,
            'publico' => $this->publico,
            'fecha' => $this->fecha->format('Y-m-d'),
            'estado' => $this->estado,
            'tipoComentario' => new TipoComentarioResource($this->tipoComentario),
            'positivo' => $this->positivo,
            'receptor' => new ColaboradorResource($this->receptor),
            'autor' => new ColaboradorResource($this->autor),
        ];
    }
}
