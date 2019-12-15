<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return new ColaboradorResource($colaborador);
    }
}
