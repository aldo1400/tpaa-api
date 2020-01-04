<?php

namespace App\Http\Controllers\TipoAreas;

use App\TipoArea;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $tipoArea = TipoArea::findOrFail($id);
        $tipoArea->delete();

        return response()->json();
    }
}
