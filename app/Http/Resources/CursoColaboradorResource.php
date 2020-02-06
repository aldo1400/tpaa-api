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
            'diploma_url' => $this->diploma_url ? $this->diploma_url : '',
            'diploma_path' => $this->diploma_url ? url(Storage::url($this->diploma_url)) : '',
            'curso_id' => $this->curso->id,
            'colaborador_id' => $this->colaborador->id,
        ];
    }
}
