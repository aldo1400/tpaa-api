<?php

namespace App\Http\Controllers\Periodos;

use App\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Resources\PeriodoResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $periodos = Periodo::all();

        return PeriodoResource::collection($periodos);
    }
}
