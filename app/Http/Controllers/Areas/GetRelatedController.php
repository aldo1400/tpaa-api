<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class GetRelatedController extends Controller
{
    public function __invoke($id){
        $area=Area::findOrFail($id);
        $areas=$area->obtenerAreasRelacionadas();
        // dd($areas->count());
        return AreaResource::collection($areas);
    }
}
