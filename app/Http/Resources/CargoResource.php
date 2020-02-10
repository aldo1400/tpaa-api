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
        if ($this->organigrama) {
            if (!(Storage::disk('local')->exists($this->organigrama_url))) {
                $ext = pathinfo($this->organigrama_url, PATHINFO_EXTENSION);
                if ($ext) {
                    $url = 'public/cargos/'.$this->id.'_'.$this->nombre.'_organigrama'.'.'.$ext;
                } else {
                    $url = 'public/cargos/'.$this->id.'_'.$this->nombre.'_organigrama'.'.pdf';
                }

                Storage::disk('local')
                        ->put($url, base64_decode($this->organigrama));
            }
        } else {
            if ($this->organigrama_url) {
                $content = Storage::get($this->organigrama_url);
                if ($content) {
                    $this->update([
                        'organigrama' => $content,
                    ]);
                }
            }
        }

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
