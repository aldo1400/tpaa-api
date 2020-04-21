<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\ResultadoArea;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $periodo = Periodo::findOrFail($id);

        if ($periodo->encuestasRelacionadas()) {
            return response()->json(['message' => 'El periodo tiene encuestas relacionadas.'], 409);
        }

        ResultadoArea::where('periodo_id', $periodo->id)->delete();

        $periodo->delete();

        return response()->json();
    }
}
