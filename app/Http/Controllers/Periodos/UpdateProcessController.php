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
        $periodo->fill($request->validated());
        $periodo->encuestaPlantilla()->associate($request->encuesta_plantilla_id);
        $periodo->save();

        return response()->json();
    }
}
