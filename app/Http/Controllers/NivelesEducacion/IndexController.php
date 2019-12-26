<?php

namespace App\Http\Controllers\NivelesEducacion;

use App\NivelEducacion;
use App\Http\Controllers\Controller;
use App\Http\Resources\NivelEducacionResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $nivelesEducacion = NivelEducacion::all();

        return NivelEducacionResource::collection($nivelesEducacion);
    }
}
