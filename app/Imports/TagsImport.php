<?php

namespace App\Imports;

use App\Tag;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TagsImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Tag([
            'nombre' => $row['nombre'],
            'descripcion' => $row['descripcion'],
            'permisos' => $row['permisos'],
            'tipo' => $row['tipo'],
        ]);
    }
}
