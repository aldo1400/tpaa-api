<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $area = Area::findOrFail($id);

        // if ($departamento->encontrarDepartamentoInferior()) {
        //     return response()->json(['status' => 'El departamento tiene hijos.'], 409);
        // }

        $area->delete();

        return response()->json();
    }
}
