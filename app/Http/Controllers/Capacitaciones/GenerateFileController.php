<?php

namespace App\Http\Controllers\Capacitaciones;

use App\CursoColaborador;
use App\Http\Controllers\Controller;

class GenerateFileController extends Controller
{
    public function __invoke($id)
    {
        $cursoColaborador = CursoColaborador::findOrFail($id);
        $cursoColaborador->generarArchivoDeDiploma();

        return response()->json();
    }
}
