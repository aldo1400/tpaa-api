<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $colaboradores = Colaborador::all();

        return ColaboradorResource::collection($colaboradores);
    }
}
