<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateUniqueController extends Controller
{
    public function __invoke(Request $request)
    {
        $areas = Area::where('nombre', $request->nombre)->get();

        if ($areas->count()) {
            return response()->json([
                'message' => 'Area duplicada',
                'errors' => [
                    'nombre' => 'Nombre de área duplicado.',
                ],
            ], 422);
        }

        return response()->json();
    }
}
