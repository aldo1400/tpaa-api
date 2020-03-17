<?php

namespace App\Http\Controllers\Consultas;

use App\Consulta;
use App\Http\Controllers\Controller;
use App\Http\Resources\ConsultaResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $consulta = Consulta::findOrFail($id);

        return new ConsultaResource($consulta);
    }
}
