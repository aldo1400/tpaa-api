<?php

namespace App\Http\Controllers\Encuestas\Colaboradores;

use App\Encuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $this->validate($request, [
            'colaboradores' => 'required|array',
            'colaboradores.*' => 'required|distinct|exists:colaboradores,id',
        ]);

        $encuesta = Encuesta::findOrFail($id);
        $datos = [];

        foreach ($request->colaboradores as $colaborador) {
            $url = $encuesta->generarUrl($colaborador);
            $datos[$colaborador] = ['estado' => '4', 'url' => $url];
        }

        $encuesta->colaboradores()->sync($datos);

        return response()->json();
    }
}
