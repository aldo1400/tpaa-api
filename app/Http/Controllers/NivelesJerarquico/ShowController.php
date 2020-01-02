<?php

namespace App\Http\Controllers\NivelesJerarquico;

use App\NivelJerarquico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NivelJerarquicoResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $nivelJerarquico = NivelJerarquico::findOrFail($id);

        return new NivelJerarquicoResource($nivelJerarquico);
    }
}
