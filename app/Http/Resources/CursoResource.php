<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CursoResource extends JsonResource
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
            'titulo'=>$this->titulo,
            'horas_cronologicas'=>$this->horas_cronologicas,
            'realizado'=>$this->realizado,
            'fecha_inicio'=>$this->fecha_inicio ? $this->fecha_inicio->format('Y-m-d'):'',
            'fecha_termino'=>$this->fecha_termino ? $this->fecha_termino->format('Y-m-d') :'',
            'anio'=>$this->anio,
            'estado' => $this->estado,
            'interno'=>$this->interno,
            'tipoCurso'=>new TipoCursoResource($this->tipoCurso)
        ];
    }
}
