<?php

namespace App\Http\Controllers\Consultas;

use App\Consulta;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        return response()->json();
    }
}
