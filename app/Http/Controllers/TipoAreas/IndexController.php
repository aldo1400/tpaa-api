<?php

namespace App\Http\Controllers\TipoAreas;

use App\TipoArea;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoAreaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tiposArea = TipoArea::all();

        return TipoAreaResource::collection($tiposArea);
    }
}
