<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Resources\PeriodoResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $periodo = Periodo::findOrFail($id);

        return new PeriodoResource($periodo);
    }
}
