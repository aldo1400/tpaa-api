<?php

namespace App\Imports;

use App\EncuestaPlantilla;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EncuestaPlantillasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $encuestaPlantilla = new EncuestaPlantilla([
            'nombre' => $row['nombre'],
            'evaluacion' => $row['evaluacion'],
            'descripcion' => $row['descripcion'],
            'tipo_puntaje' => $row['tipo_puntaje'],
            'tiene_item' => $row['tiene_item'],
            'numero_preguntas' => $row['numero_preguntas'],
        ]);

        return $encuestaPlantilla;
    }
}
