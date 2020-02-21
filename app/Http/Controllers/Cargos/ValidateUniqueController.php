<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateUniqueController extends Controller
{
    public function __invoke(Request $request)
    {
        $cargos = Cargo::where('nombre', $request->nombre)->get();

        if ($cargos->count()) {
            return response()->json([
                'message' => 'Cargo duplicado',
                'errors' => [
                    'nombre' => 'Nombre de cargo duplicado.',
                ],
            ], 422);
        }

        return response()->json();
    }
}
