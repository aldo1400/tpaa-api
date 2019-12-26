<?php

namespace App\Http\Controllers\Colaboradores\CargasFamiliares;

use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return new CargaFamiliarResource($colaborador->cargaFamiliar);
    }
}
