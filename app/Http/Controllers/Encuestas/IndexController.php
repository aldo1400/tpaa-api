<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Http\Controllers\Controller;
use App\Http\Resources\EncuestaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $encuestas = Encuesta::all();

        return EncuestaResource::collection($encuestas);
    }
}
