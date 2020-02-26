<?php

namespace App\Imports;

use App\Area;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AreasImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $area = new Area([
            'nombre' => $row['nombre'],
        ]);

        $area->padre_id = $row['padre_id'];
        $area->tipo_area_id = $row['area_tipo'];

        return $area;
    }
}
