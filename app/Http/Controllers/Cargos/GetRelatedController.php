<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class GetRelatedController extends Controller
{
    public function __invoke($id){
        $cargo=Cargo::findOrFail($id);
        $areas=$cargo->area->obtenerAreasRelacionadas();
        return AreaResource::collection($areas);
    }
}
