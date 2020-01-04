<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Requests\AreaRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(AreaRequest $request)
    {
        //TODO:Validar valor del padre
        $area = Area::make($request->validated());

        $area->padre()->associate($request->padre_id);
        $area->tipoArea()->associate($request->tipo_area_id);
        $area->save();

        return response()->json(null, 201);
    }
}
