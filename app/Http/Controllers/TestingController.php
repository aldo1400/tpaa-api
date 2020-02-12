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
        );

        // dd($colaborador);

        $pdf = PDF::loadView('capacitacion.diploma', [
            'colaborador' => $colaborador,
        ]);

        return $pdf->download('testing.pdf');
    }
}
