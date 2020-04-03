<?php

namespace App\Http\Controllers\Periodos\Encuestas;

use App\Periodo;
use App\Http\Controllers\Controller;
use App\Http\Resources\EncuestaResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $periodo = Periodo::findOrFail($id);

        return EncuestaResource::collection($periodo->encuestas);
    }
}
