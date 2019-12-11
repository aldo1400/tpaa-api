<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $cargo = Cargo::findOrFail($id);

        if ($cargo->encontrarCargoInferior()) {
            return response()->json(['status' => 'El cargo tiene hijos.'], 409);
        }

        $cargo->delete();

        return response()->json();
    }
}
