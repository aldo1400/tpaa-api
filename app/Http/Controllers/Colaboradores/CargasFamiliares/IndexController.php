<?php

namespace App\Http\Controllers\Colaboradores\CargasFamiliares;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargaFamiliarResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return CargaFamiliarResource::collection($colaborador->cargasFamiliares);
    }
}
