<?php

namespace App\Http\Controllers\NivelesJerarquico;

use App\NivelJerarquico;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $nivelJerarquico = NivelJerarquico::findOrFail($id);
        $nivelJerarquico->delete();

        return response()->json();
    }
}
