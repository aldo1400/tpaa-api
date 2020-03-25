<?php

namespace App\Http\Controllers\Consultas;

use App\Consulta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateStatusReadController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $this->validate($request, [
            'leido' => 'required|boolean',
        ]);

        $consulta = Consulta::findOrFail($id);

        $consulta->update([
            'leido' => $request->leido,
        ]);

        return response()->json();
    }
}
