<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $areas = Area::all();

        return AreaResource::collection($areas);
    }
}
