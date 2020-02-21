<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateUniqueUpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $cargo = Cargo::findOrFail($id);
        $cargos = Cargo::where('nombre', $request->nombre)->get();

        if ($cargos->count()) {
            if ($cargos[0]->nombre != $cargo->nombre) {
                return response()->json([
                        'message' => 'Cargo duplicado',
                        'errors' => [
                            'nombre' => 'Nombre de cargo duplicado.',
                        ],
                    ], 422);
            }
        }

        return response()->json();
    }
}
