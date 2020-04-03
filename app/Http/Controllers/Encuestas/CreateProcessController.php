<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Helpers\Date;
use App\Http\Controllers\Controller;
use App\Http\Requests\EncuestaRequest;

class CreateProcessController extends Controller
{
    public function __invoke(EncuestaRequest $request)
    {
        if (!Date::revisarFechaDeInicioYTermino($request->fecha_inicio, $request->fecha_fin)) {
            return response()->json([
                    'message' => 'Fecha de termino debe ser mayor a la fecha de inicio.',
                    'errors' => [
                        'fecha_inicio' => 'Fecha inválida.',
                        'fecha_fin' => 'Fecha inválida.',
                    ],
                ], 409);
        }

        $encuesta = Encuesta::make($request->validated());
        $encuesta->periodo()->associate($request->periodo_id);
        $encuesta->save();

        return response()->json(null, 201);
    }
}
