<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class GetRelatedController extends Controller
{
    public function __invoke($id)
    {
        $area = Area::findOrFail($id);
        $areas = $area->obtenerAreasRelacionadas();

        return AreaResource::collection($areas);
    }
}
