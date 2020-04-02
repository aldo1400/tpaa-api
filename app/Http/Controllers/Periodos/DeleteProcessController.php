<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $periodo = Periodo::findOrFail($id);

        if ($periodo->encuestasRelacionadas()) {
            return response()->json(['message' => 'El periodo tiene encuestas relacionadas.'], 409);
        }

        $periodo->delete();

        return response()->json();
    }
}
