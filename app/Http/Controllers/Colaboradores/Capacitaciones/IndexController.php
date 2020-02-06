<?php

namespace App\Http\Controllers\Colaboradores\Capacitaciones;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoColaboradorResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return CursoColaboradorResource::collection($colaborador->capacitaciones);
    }
}
