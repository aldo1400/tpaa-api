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
            'supervisor_id' => $this->supervisor_id ? $this->supervisor_id : '',
            'estado' => $this->estado,
            'nivelJerarquico' => new NivelJerarquicoResource($this->nivelJerarquico),
            'area' => new AreaResource($this->area),
            'organigrama_url' => $this->organigrama_url ? $this->organigrama_url : '',
            'organigrama_path' => $this->organigrama_url ? url(Storage::url($this->organigrama_url)) : '',
            'descriptor_url' => $this->descriptor_url ? $this->descriptor_url : '',
            'descriptor_path' => $this->descriptor_url ? url(Storage::url($this->descriptor_url)) : '',
            'hijos' => $this->encontrarCargoInferior() ? true : false,
            'movilidades' => $this->movilidades()->where('estado', 1)->count() ? true : false,
            'updated_at' => $this->updated_at->format('d/m/Y'),
            'nombre_fantasia' => $this->nombre_fantasia ? $this->nombre_fantasia : '',
        ];
    }
}
