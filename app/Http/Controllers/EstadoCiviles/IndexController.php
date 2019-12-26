<?php

namespace App\Http\Controllers\EstadoCiviles;

use App\EstadoCivil;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstadoCivilResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $estadoCiviles = EstadoCivil::all();

        return EstadoCivilResource::collection($estadoCiviles);
    }
}
