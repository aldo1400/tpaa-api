<?php

namespace App\Http\Controllers\TipoAreas;

use App\TipoArea;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoAreaResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $tipoArea = TipoArea::findOrFail($id);

        return new TipoAreaResource($tipoArea);
    }
}
