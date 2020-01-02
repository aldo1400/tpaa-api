<?php

namespace App\Http\Controllers\NivelesJerarquico;

use App\NivelJerarquico;
use App\Http\Controllers\Controller;
use App\Http\Requests\NivelJerarquicoRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(NivelJerarquicoRequest $request, $id)
    {
        $nivelJerarquico = NivelJerarquico::findOrFail($id);
        $nivelJerarquico->update($request->validated());

        return response()->json();
    }
}
