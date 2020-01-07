<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $area = Area::findOrFail($id);

        if ($area->encontrarAreaInferior()) {
            return response()->json(['status' => 'El area tiene hijos.'], 409);
        }

        $area->delete();

        return response()->json();
    }
}
