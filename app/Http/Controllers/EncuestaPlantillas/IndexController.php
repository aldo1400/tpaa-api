<?php

namespace App\Http\Controllers\EncuestaPlantillas;

use App\EncuestaPlantilla;
use App\Http\Controllers\Controller;
use App\Http\Resources\EncuestaPlantillaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $encuestaPlantillas = EncuestaPlantilla::all();

        return EncuestaPlantillaResource::collection($encuestaPlantillas);
    }
}
