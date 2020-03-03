<?php

namespace App\Imports;

use App\Cargo;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CargosImport implements ToCollection, WithHeadingRow
{
    protected $_idUsuario;

    public function __construct($idUsuario)
    {
        $this->_idUsuario = $idUsuario;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $cargo = Cargo::make([
                'nombre' => $row['nombre'],
                'descriptor_url' => $row['descriptor_url'],
                'organigrama_url' => $row['organigrama_url'],
                'nombre_fantasia' => $row['nombre_fantasia'],
                'estado' => $row['estado'],
            ]);

            $cargo->supervisor_id = $row['supervisor_id'];
            $cargo->nivel_jerarquico_id = $row['nivel_jerarquico_id'];
            $cargo->area_id = $row['area_id'];

            $cargo->save();

            $cargo->generarArchivo('organigrama');
            $cargo->generarArchivo('descriptor');
        }
    }
}
