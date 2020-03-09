<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        if ($request->fecha_inicio && $request->fecha_termino) {
            if (Carbon::parse($request->fecha_termino)->lt(Carbon::parse($request->fecha_inicio))) {
                return response()->json([
                    'message' => 'Fecha de termino debe ser mayor a la fecha de inicio de la movilidad.',
                    'errors' => [
                        'fecha_inicio' => 'Fecha inválida.',
                        'fecha_termino' => 'Fecha inválida.',
                    ],
                ], 409);
            }
        }

        $movilidad = Movilidad::findOrFail($id);

        if ($movilidad->isRenuncia() || $movilidad->isDesvinculado() || $movilidad->isTerminoDeContrato()) {
            if ($request->cargo_id) {
                return response()->json(['message' => 'El tipo de movilidad es inválido.'], 409);
            }
        }

        $movilidad->fill([
            'fecha_inicio' => $request->fecha_inicio,
            'observaciones' => $request->observaciones,
        ]);

        if (!$movilidad->estado) {
            $movilidad->fill([
                'fecha_termino' => $request->fecha_termino,
            ]);
        }

        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->save();

        return response()->json();
    }
}
