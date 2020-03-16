<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use App\Colaborador;
use App\Helpers\Date;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovilidadRequest;

class CreateHistoricController extends Controller
{
    public function __invoke(MovilidadRequest $request, $id)
    {
        if (!Date::revisarFechaDeInicioYTermino($request->fecha_inicio, $request->fecha_termino)) {
            return response()->json([
                    'message' => 'Fecha de termino debe ser mayor a la fecha de inicio de la movilidad.',
                    'errors' => [
                        'fecha_inicio' => 'Fecha inválida.',
                        'fecha_termino' => 'Fecha inválida.',
                    ],
                ], 409);
        }

        $colaborador = Colaborador::findOrFail($id);

        if (!$colaborador->validarLimitesDeFecha($colaborador->movilidades, $request->fecha_inicio, $request->fecha_termino)) {
            return response()->json(['message' => 'Fecha de inicio y termino de movilidad inválidas.'], 409);
        }

        $movilidad = Movilidad::make([
            'observaciones' => $request->observaciones,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_termino' => $request->fecha_termino,
            'estado' => 0,
        ]);

        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->tipoMovilidad()->associate($request->tipo_movilidad_id);
        $movilidad->colaborador()->associate($colaborador);
        $movilidad->save();

        return response()->json(null, 201);
    }
}
