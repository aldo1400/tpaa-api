<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use App\Colaborador;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $movilidad = Movilidad::findOrFail($id);
        $colaborador = $movilidad->colaborador;
       
        if (!$colaborador->cargoActual()) {
            return response()->json(['message' => 'El colaborador no tiene un cargo activo.'], 409);
        }

        $colaborador->movilidadActual()
                ->delete();

        $movilidad = $colaborador->movilidades()
                    ->orderBy('id', 'desc')
                    ->first();

        if ($movilidad) {
            $movilidad->update([
                'fecha_termino' => null,
                'estado' => 1,
            ]);
        }

        return response()->json();
    }
}
