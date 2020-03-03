<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade as PDF;

class TestingController extends Controller
{
    public function __invoke()
    {
        $colaborador = (object) array(
            'rut' => '15673399-7',
            'primer_nombre' => 'Felipe',
            'segundo_nombre' => 'Sebastian',
            'apellido_paterno' => 'briceño',
            'apellido_materno' => 'Briceño',
            'nombre_completo' => 'Felipe Briceño Segovia',
            'horas_cronologicas' => '35.5',
            'realizado' => 'Realizado el 25 de Marzo de 2019',
            'anio' => 'Por su aprobación en el Taller',
            'titulo' => 'PRÁCTICO DE FORMACIÓN MONITOR DE PAUSA ACTIVA',
        );

        $pdf = PDF::loadView('capacitacion.diploma', [
            'colaborador' => $colaborador,
        ]);
        $pdf->setPaper('letter', 'portrait');

        return $pdf->stream('testing.pdf');
        //return $pdf->download('testing.pdf');
    }
}
