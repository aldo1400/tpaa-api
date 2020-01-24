<?php

namespace App\Http\Controllers\TipoMovilidades;

use App\TipoMovilidad;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoMovilidadResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tipoMovilidades = TipoMovilidad::all();

        return TipoMovilidadResource::collection($tipoMovilidades);
    }
}
