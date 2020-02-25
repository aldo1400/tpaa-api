<?php

namespace App\Imports;

use App\Colaborador;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ColaboradoresImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $colaborador = new Colaborador([
            // 'id'=>$row['id'],
            // 'rut'=>$row['rut'],
            'primer_nombre' => $row['primer_nombre'],
            'segundo_nombre' => $row['segundo_nombre'],
            'apellido_paterno' => $row['apellido_paterno'],
            'apellido_materno' => $row['apellido_materno'],
            'sexo' => $row['sexo'],
            'nacionalidad' => $row['nacionalidad'],
            'fecha_nacimiento' => $row['fecha_de_nacimiento'],
            'edad' => $row['edad'],
            'email' => $row['correo'],
            'domicilio' => $row['domicilio'],
            'licencia_b' => $row['licencia_b'],
            'vencimiento_licencia_b' => $row['vencimiento_l_b'],
            'licencia_d' => $row['licencia_d'],
            'vencimiento_licencia_d' => $row['vencimiento_l_d'],
            'carnet_portuario' => $row['carnet_portuario'],
            'vencimiento_carnet_portuario' => $row['vencimiento_c_p'],
            'credencial_vigilante' => $row['credencial_de_vigilancia'],
            'vencimiento_credencial_vigilante' => $row['vencimiento_c_v'],
            'talla_calzado' => $row['talla_calzado'],
            'talla_chaleco' => $row['talla_chaleco'],
            'talla_polera' => $row['talla_polera'],
            'talla_pantalon' => $row['talla_pantalon'],
            'fecha_ingreso' => $row['fecha_de_ingreso'],
            'anexo' => $row['anexo'],
            'celular' => $row['celular'],
            'contacto_emergencia_nombre' => $row['contacto_de_emergencia'],
            'contacto_emergencia_telefono' => $row['celular_cont_emergencia'],
            'estado' => $row['estado'],
            'fecha_inactividad' => $row['fecha_de_inactividad'],
        ]);

        $colaborador->rut = $row['rut'];
        $colaborador->estado_civil_id = $row['estado_civil_id'];
        $colaborador->nivel_educacion_id = $row['nivel_educacion_id'];

        return $colaborador;
    }
}
