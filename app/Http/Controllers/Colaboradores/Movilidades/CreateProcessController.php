<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovilidadRequest;

class CreateProcessController extends Controller
{
    public function __invoke(MovilidadRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->cargoActual()
                    ->update([
                        'estado' => 0,
                        'fecha_termino' => $request->fecha_termino,
                    ]);

        $movilidad = Movilidad::make([
            'fecha_inicio' => $request->fecha_inicio,
            'tipo' => $request->tipo,
            'observaciones' => $request->observaciones,
            'estado' => 1,
        ]);

        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->colaborador()->associate($colaborador);

        $movilidad->save();

        return response()->json(null, 201);
    }
}
