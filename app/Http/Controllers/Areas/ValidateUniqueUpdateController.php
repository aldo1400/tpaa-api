<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateUniqueUpdateController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $area = Area::findOrFail($id);
        $areas = Area::where('nombre', $request->nombre)->get();

        if ($areas->count()) {
            if ($areas[0]->nombre != $area->nombre) {
                return response()->json([
                        'message' => 'Area duplicada',
                        'errors' => [
                            'nombre' => 'Nombre de área duplicado.',
                        ],
                    ], 422);
            }
        }

        return response()->json();
    }
}
