<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateUniqueController extends Controller
{
    public function __invoke(Request $request)
    {
        $area = Area::where('nombre', $request->nombre)->get();

        if ($area) {
            return response()->json([
                'message' => 'Data inválida',
                'errors' => [
                    'nombre' => 'Nombre de área duplicado.',
                ],
            ], 422);
        }

        return response()->json();
    }
}
