<?php

namespace App\Imports;

use App\Movilidad;
use Carbon\Carbon;
use App\Colaborador;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MovilidadesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $colaborador = Colaborador::where('rut', $row['colaborador_rut'])->first();
        $movilidad = new Movilidad([
            'fecha_inicio' => $row['fecha_inicio'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_inicio'])) : null,
            'fecha_termino' => $row['fecha_termino'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_termino'])) : null,
            'observaciones' => $row['observaciones'],
            'estado' => $row['estado'],
        ]);

        $movilidad->tipo_movilidad_id = $row['tipo_movilidad_id'];
        $movilidad->cargo_id = $row['cargo_id'];
        $movilidad->colaborador_id = $colaborador->id;

        return $movilidad;
    }
}
