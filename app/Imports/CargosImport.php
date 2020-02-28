<?php

namespace App\Imports;

use App\Cargo;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CargosImport implements ToModel, WithHeadingRow
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
    public function model(array $row)
    {
        $cargo = new Cargo([
            'nombre' => $row['nombre'],
            'descriptor_url' => $row['descriptor_url'],
            'organigrama_url' => $row['organigrama_url'],
            'nombre_fantasia' => $row['nombre_fantasia'],
            'estado' => $row['estado'],
        ]);

        $cargo->supervisor_id = $row['supervisor_id'];
        $cargo->nivel_jerarquico_id = $row['nivel_jerarquico_id'];
        $cargo->area_id = $row['area_id'];

        $cargo->generarArchivo('organigrama');
        $cargo->generarArchivo('descriptor');

        return $cargo;
    }
}
