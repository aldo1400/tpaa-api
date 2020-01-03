<?php

namespace App\Http\Controllers\TipoAreas;

use App\TipoArea;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoAreaRequest;

class CreateProcessController extends Controller
{
    public function __invoke(TipoAreaRequest $request)
    {
        $tipoArea = TipoArea::make($request->validated());
        $tipoArea->nivel = $tipoArea->nuevoNivel();
        $tipoArea->save();

        return response()->json(null, 201);
    }
}
