<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Colaborador;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ColaboradoresImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            $colaborador = Colaborador::make([
            'primer_nombre' => $row['primer_nombre'],
            'segundo_nombre' => $row['segundo_nombre'],
            'apellido_paterno' => $row['apellido_paterno'],
            'apellido_materno' => $row['apellido_materno'],
            'sexo' => $row['sexo'],
            'nacionalidad' => $row['nacionalidad'],
            'fecha_nacimiento' => $row['fecha_nacimiento'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_nacimiento'])) : null,
            'edad' => $row['edad'],
            'domicilio' => $row['domicilio'],
            'licencia_b' => $row['licencia_b'],
            'vencimiento_licencia_b' => $row['vencimiento_licencia_b'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['vencimiento_licencia_b'])) : null,
            'licencia_d' => $row['licencia_d'],
            'vencimiento_licencia_d' => $row['vencimiento_licencia_d'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['vencimiento_licencia_d'])) : null,
            'carnet_portuario' => $row['carnet_portuario'],
            'vencimiento_carnet_portuario' => $row['vencimiento_carnet_portuario'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['vencimiento_carnet_portuario'])) : null,
            'credencial_vigilante' => $row['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $row['vencimiento_credencial_vigilante'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['vencimiento_credencial_vigilante'])) : null,
            'talla_calzado' => $row['talla_calzado'],
            'talla_chaleco' => $row['talla_chaleco'],
            'talla_polera' => $row['talla_polera'],
            'talla_pantalon' => $row['talla_pantalon'],
            'fecha_ingreso' => $row['fecha_ingreso'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_ingreso'])) : null,
            'email' => $row['email'],
            'telefono' => $row['telefono'],
            'celular' => $row['celular'],
            'anexo' => $row['anexo'],
            'contacto_emergencia_nombre' => $row['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $row['contacto_emergencia_telefono'],
            'fecha_inactividad' => $row['fecha_inactividad'] ? Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_inactividad'])) : null,
            'estado' => $row['estado'],
        ]);

            $colaborador->rut = $row['rut'];
            $colaborador->estado_civil_id = $row['estado_civil_id'];
            $colaborador->nivel_educacion_id = $row['nivel_educacion_id'];
            $colaborador->imagen_url = $row['imagen_url'];

            $colaborador->save();
            $colaborador->generarImagen();
        }
    }

    /**
     * Transform a date value into a Carbon object.
     *
     * @return \Carbon\Carbon|null
     */
    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            return \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
