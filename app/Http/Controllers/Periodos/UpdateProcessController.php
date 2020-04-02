<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeriodoRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(PeriodoRequest $request, $id)
    {
        $periodo = Periodo::findOrFail($id);

        if ($periodo->encuestasRelacionadas()) {
            return response()->json(['message' => 'El periodo tiene encuestas relacionadas.'], 409);
        }

        $periodo->fill($request->validated());
        $periodo->encuestaPlantilla()->associate($request->encuesta_plantilla_id);
        $periodo->save();

        return response()->json();
    }
}
