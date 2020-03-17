<?php

namespace App\Http\Controllers\Consultas;

use App\Consulta;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $consultas = Consulta::all();

        return ConsultaResource::collection($consultas);
    }
}
