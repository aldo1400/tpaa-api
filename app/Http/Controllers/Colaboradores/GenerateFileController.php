<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Http\Controllers\Controller;

class GenerateFileController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);
        // dd($colaborador->id);
        $colaborador->generarImagen();

        return response()->json();
    }
}
