<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Controllers\Controller;

class GenerateFileController extends Controller
{
    public function __invoke($id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargo->generarArchivo('organigrama');
        $cargo->generarArchivo('descriptor');

        return response()->json();
    }
}
