<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $this->validate($request, [
            'nombre' => 'string|required|max:255',
        ]);

        $cargo = Cargo::findOrFail($id);

        $cargo->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json();
    }
}
