<?php

namespace App\Http\Controllers\TipoAreas;

use App\TipoArea;
use App\Http\Controllers\Controller;
use App\Http\Requests\TipoAreaRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(TipoAreaRequest $request, $id)
    {
        $tipoArea = TipoArea::findOrFail($id);
        $tipoArea->update($request->validated());

        return response()->json();
    }
}
