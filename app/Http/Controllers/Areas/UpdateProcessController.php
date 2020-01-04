<?php

namespace App\Http\Controllers\Departamentos;

use App\Departamento;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $this->validate($request, [
            'nombre' => 'string|required|max:255',
        ]);

        $departamento = Departamento::findOrFail($id);

        $departamento->update([
            'nombre' => $request->nombre,
        ]);

        return response()->json();
    }
}
