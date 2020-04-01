<?php

namespace App\Http\Controllers\EncuestaPlantillas\Preguntas;

use App\EncuestaPlantilla;
use App\Http\Controllers\Controller;
use App\Http\Resources\PreguntaResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $encuestaPlantilla = EncuestaPlantilla::findOrFail($id);

        return PreguntaResource::collection($encuestaPlantilla->preguntas);
    }
}
