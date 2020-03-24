<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use Carbon\Carbon;
use App\Colaborador;
use App\TipoMovilidad;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovilidadRequest;

class CreateProcessController extends Controller
{
    public function __invoke(MovilidadRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);

        $tipoMovilidad = TipoMovilidad::findOrFail($request->tipo_movilidad_id);

        if (!$colaborador->tieneMovilidades() && !$tipoMovilidad->isNuevo()) {
            return response()->json(['message' => 'El tipo de movilidad es inválido.'], 409);
        }

        if ($tipoMovilidad->isExcluyente() && $request->cargo_id) {
            return response()->json(['message' => 'El cargo es inválido.'], 409);
        }

        if ($colaborador->tieneMovilidades()) {
            if (Carbon::parse($request->fecha_termino)->lte($colaborador->movilidadActual()->fecha_inicio)) {
                return response()->json(['message' => 'Fecha de Termino debe ser mayor a la Fecha de Inicio del Cargo Actual.'], 409);
            }

            if (Carbon::parse($request->fecha_inicio)->lte(Carbon::parse($request->fecha_termino))) {
                return response()->json(['message' => 'Fecha de inicio de Cargo Nuevo debe ser posterior a la Fecha de Termino de Cargo Actual.'], 409);
            }

            $colaborador->movilidadActual()
                        ->update([
                            'estado' => 0,
                            'fecha_termino' => $request->fecha_termino,
                        ]);
        }

        $movilidad = Movilidad::make([
            'observaciones' => $request->observaciones,
            'fecha_inicio' => $request->fecha_inicio,
        ]);

        $movilidad->tipoMovilidad()->associate($request->tipo_movilidad_id);
        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->colaborador()->associate($colaborador);

        $movilidad->save();

        return response()->json(null, 201);
    }
}
