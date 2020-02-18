<?php

namespace App\Http\Controllers\Colaboradores\Comentarios;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComentarioResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return ComentarioResource::collection($colaborador->comentariosRecibidos);
    }
}
