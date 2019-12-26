<?php

namespace App\Http\Controllers\CargasFamiliares;

use App\CargaFamiliar;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargaFamiliarResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $cargaFamiliar = CargaFamiliar::findOrFail($id);

        return new CargaFamiliarResource($cargaFamiliar);
    }
}
