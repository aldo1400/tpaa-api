<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CursoColaboradorResource extends JsonResource
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
            'diploma_url' => $this->url_diploma ? $this->url_diploma : '',
            'diploma_path' => $this->url_diploma ? url(Storage::url($this->url_diploma)) : '',
            'curso_id' => $this->curso->id,
            'curso_nombre' => $this->curso->nombre,
            'colaborador_id' => $this->colaborador->id,
        ];
    }
}
