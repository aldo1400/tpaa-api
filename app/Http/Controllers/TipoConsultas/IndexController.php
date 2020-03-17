<?php

namespace App\Http\Controllers\TipoConsultas;

use App\TipoConsulta;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoConsultaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tipoConsultas = TipoConsulta::all();

        return TipoConsultaResource::collection($tipoConsultas);
    }
}
