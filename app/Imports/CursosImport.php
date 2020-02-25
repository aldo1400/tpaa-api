<?php

namespace App\Imports;

use App\Curso;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CursosImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $curso = new Curso([
            'nombre' => $row['nombre'],
            'titulo' => $row['titulo'],
            'horas_cronologicas' => $row['horas_cronologicas'],
            'realizado' => $row['realizado'],
            'fecha_inicio' => $row['fecha_inicio'],
            'fecha_termino' => $row['fecha_termino'],
            'anio' => $row['anio'],
            'interno' => $row['interno'],
        ]);

        $cargo->tipo_curso_id = $row['tipo_curso_id'];

        return $curso;
    }
}
