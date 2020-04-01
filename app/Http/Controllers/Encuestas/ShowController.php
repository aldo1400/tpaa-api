<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Http\Controllers\Controller;
use App\Http\Resources\EncuestaResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $encuesta = Encuesta::findOrFail($id);

        return new EncuestaResource($encuesta);
    }
}
