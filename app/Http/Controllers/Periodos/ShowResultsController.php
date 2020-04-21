<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResultadoAreaResource;

class ShowResultsController extends Controller
{
    public function __invoke($id)
    {
        $periodo = Periodo::findOrFail($id);

        return ResultadoAreaResource::collection($periodo->resultadoAreas->sortByDesc('tipo_area_id'));
    }
}
