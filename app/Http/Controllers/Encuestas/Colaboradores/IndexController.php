<?php

namespace App\Http\Controllers\Encuestas\Colaboradores;

use App\Encuesta;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorShortResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $encuesta = Encuesta::findOrFail($id);

        return ColaboradorShortResource::collection($encuesta->colaboradores);
    }
}
