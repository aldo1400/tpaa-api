<?php

namespace App\Http\Controllers\Colaboradores\Encuestas;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\EncuestaResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return EncuestaResource::collection($colaborador->encuestas);
    }
}
