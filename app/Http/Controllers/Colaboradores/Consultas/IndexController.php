<?php

namespace App\Http\Controllers\Colaboradores\Consultas;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultaResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return ConsultaResource::collection($colaborador->consultas);
    }
}
