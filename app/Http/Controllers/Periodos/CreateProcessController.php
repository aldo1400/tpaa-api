<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Requests\PeriodoRequest;

class CreateProcessController extends Controller
{
    public function __invoke(PeriodoRequest $request)
    {
        $periodo = Periodo::make($request->validated());
        $periodo->encuestaPlantilla()->associate($request->encuesta_plantilla_id);
        $periodo->save();

        return response()->json(null, 201);
    }
}
