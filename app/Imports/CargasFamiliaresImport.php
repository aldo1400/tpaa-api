<?php

namespace App\Imports;

use App\Colaborador;
use App\CargaFamiliar;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CargasFamiliaresImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $colaborador = Colaborador::where('rut', $row['rut_colaborador'])->first();

        $cargaFamiliar = new CargaFamiliar([
            'rut' => $row['rut_carga'],
            'nombres' => $row['nombres_carga'],
            'apellidos' => $row['apellido_carga'],
            'fecha_nacimiento' => $row['fecha_de_nacimiento'],
        ]);

        $cargaFamiliar->colaborador_id = $colaborador->id;

        $cargaFamiliar->tipo_carga_id = $row['tipo_carga_id'];

        return $cargaFamiliar;
    }

    public function rules(): array
    {
        return [
            'rut_carga' => [
                            'nullable',
                            Rule::unique('cargas_familiares', 'rut'),
                         ],
            'nombres_carga' => ['required', 'string', 'max:255'],
            'nombres_carga' => ['required', 'string', 'max:255'],
            'rut_colaborador' => ['required', 'exists:colaboradores,rut'],
            'tipo_carga_id' => ['required', 'exists:tipo_cargas,id'],
        ];
    }
}
