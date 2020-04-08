<?php

namespace App\Imports;

use App\Pregunta;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PreguntasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $pregunta = new Pregunta([
            'pregunta' => $row['pregunta'],
            'tipo' => $row['tipo'],
            'item' => $row['item'],
        ]);

        $pregunta->encuesta_plantilla_id = $row['encuesta_plantilla_id'];

        return $pregunta;
    }
}
