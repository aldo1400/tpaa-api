<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
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
            'nombre' => $this->nombre,
            'supervisor_id' => $this->supervisor_id ? $this->supervisor_id :'',
            'estado' => $this->estado,
            'nivelJerarquico' => new NivelJerarquicoResource($this->nivelJerarquico),
            'area' => new AreaResource($this->area),
            'organigrama_url'=> $this->organigrama_url ? url(Storage::url($this->organigrama_url)) : '',
            'descriptor_url'=> $this->descriptor_url ? url(Storage::url($this->descriptor_url)) : ''
        ];
    }
}
