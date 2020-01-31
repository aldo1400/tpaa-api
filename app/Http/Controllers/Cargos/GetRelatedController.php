<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class GetRelatedController extends Controller
{
    public function __invoke($id)
    {
        $cargo = Cargo::findOrFail($id);

        $areas = $cargo->area->obtenerAreasRelacionadas();
        $areas=$areas->push($cargo->area)->sortBy('tipo_area_id');

        return AreaResource::collection($areas);
    }
}
