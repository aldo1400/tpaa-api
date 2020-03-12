<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $movilidad = Movilidad::findOrFail($id);
        $colaborador = $movilidad->colaborador;

        $colaborador->movilidadActual()
                ->delete();

        $movilidadAnterior = $colaborador->movilidades()
                    ->orderBy('id', 'desc')
                    ->first();

        if ($movilidadAnterior) {
            $movilidadAnterior->update([
                'fecha_termino' => null,
                'estado' => 1,
            ]);
        }

        $colaborador->actualizarEstadoSegunMovilidad($movilidad);

        return response()->json();
    }
}
