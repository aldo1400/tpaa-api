<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $area = Area::findOrFail($id);

        return new AreaResource($area);
    }
}
