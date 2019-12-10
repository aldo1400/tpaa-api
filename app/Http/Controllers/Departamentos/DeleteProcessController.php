<?php

namespace App\Http\Controllers\Departamentos;

use App\Departamento;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $departamento = Departamento::findOrFail($id);
        // dd('hola');
        if ($departamento->encontrarDepartamentoInferior()) {
            return response()->json(['status' => 'El departamento tiene hijos.'], 409);
        }

        $departamento->delete();

        return response()->json();
    }
}
