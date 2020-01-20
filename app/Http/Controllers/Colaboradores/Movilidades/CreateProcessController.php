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

        if ($request->tipo == Colaborador::DESVINCULADO || $request->tipo == Colaborador::RENUNCIA) {
            $movilidad = Movilidad::make([
                            'fecha_inicio' => $request->fecha_termino,
                            'tipo' => $request->tipo,
                            'observaciones' => $request->observaciones,
                            'estado' => 1,
                        ]);

            $colaborador->estado = $request->tipo;
            $colaborador->fecha_inactividad = $request->fecha_termino;
            $colaborador->save();
        } else {
            $movilidad = Movilidad::make([
                            'fecha_inicio' => $request->fecha_inicio,
                            'tipo' => $request->tipo,
                            'observaciones' => $request->observaciones,
                            'estado' => 1,
                        ]);
        }

        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->colaborador()->associate($colaborador);

        $movilidad->save();

        return response()->json(null, 201);
    }
}
