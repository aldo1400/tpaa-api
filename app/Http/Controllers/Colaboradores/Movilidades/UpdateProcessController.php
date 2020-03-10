<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use App\Helpers\Date;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke(Request $request, $id)
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

        $movilidad = Movilidad::findOrFail($id);

        if ($movilidad->isTipoExcluyente() && $request->cargo_id) {
            return response()->json(['message' => 'El tipo de movilidad es inválido.'], 409);
        }

        if (!$movilidad->isActivo() && !$request->fecha_termino) {
            return response()->json(['message' => 'Debe enviar fecha de termino es inválido.'], 409);
        }

        if (!$movilidad->validarNuevasFechas($request->fecha_inicio, $request->fecha_termino)) {
            return response()->json(['message' => 'Fecha de inicio y termino de movilidad inválidas.'], 409);
        }

        $movilidad->fill([
            'fecha_inicio' => $request->fecha_inicio,
            'observaciones' => $request->observaciones,
            'fecha_termino' => $movilidad->isActivo() ? $movilidad->fecha_termino : $request->fecha_termino,
        ]);

        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->save();

        return response()->json();
    }
}
