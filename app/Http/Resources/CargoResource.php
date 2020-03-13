<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Http\Resources\Json\JsonResource;

class CargoResource extends JsonResource
{
    /**
     * @var
     */
    private $getColaborador;

    /**
     * Create a new resource instance.
     *
     * @param mixed $resource
     */
    public function __construct($resource)
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);
        $this->resource = $resource;
        // var_dump($colaborador);
        // $this->getColaborador = $colaborador;
    }

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        // if ($this->getColaborador) {
        $movilidad = $this->movilidades
                ->where('estado', 1)
                    ->first();
        // dd($movilidad->colaborador);
        if ($movilidad) {
            $colaborador = $movilidad->colaborador;
        }
        // }

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
            'colaborador_actual_rut' => isset($colaborador) ? $colaborador->rut : '',
            'colaborador_actual_primer_nombre' => isset($colaborador) ? $colaborador->primer_nombre : '',
            'colaborador_actual_segundo_nombre' => isset($colaborador) ? $colaborador->segundo_nombre : '',
            'colaborador_actual_apellido_paterno' => isset($colaborador) ? $colaborador->apellido_paterno : '',
            'colaborador_actual_apellido_materno' => isset($colaborador) ? $colaborador->apellido_materno : '',
            'colaborador_actual_imagen_url' => isset($colaborador) ? $colaborador->imagen_url : '',
        ];
    }
}
