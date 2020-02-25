<?php

namespace App\Imports;

use App\CargaFamiliar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CargasFamiliaresImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $cargaFamiliar = new CargaFamiliar([
            'rut' => $row['rut'],
            'nombres' => $row['nombres'],
            'apellidos' => $row['apellidos'],
            'fecha_nacimiento' => $row['fecha_nacimiento'],
        ]);

        $cargaFamiliar->colaborador_id = $row['colaborador_id'];
        $cargaFamiliar->tipo_carga_id = $row['tipo_carga_id'];

        return $cargaFamiliar;
    }
}
