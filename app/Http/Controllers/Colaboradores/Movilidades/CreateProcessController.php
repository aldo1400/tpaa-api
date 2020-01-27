<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Movilidad;
use App\Colaborador;
use App\TipoMovilidad;
use App\Http\Controllers\Controller;
use App\Http\Requests\MovilidadRequest;

class CreateProcessController extends Controller
{
    public function __invoke(MovilidadRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        if ($colaborador->cargoActual()) {
            $colaborador->cargoActual()
            ->update([
                'estado' => 0,
                'fecha_termino' => $request->fecha_termino,
            ]);
        }

        $tipoMovilidad = TipoMovilidad::findOrFail($request->tipo_movilidad_id);

        $movilidad = Movilidad::make([
            'observaciones' => $request->observaciones,
        ]);

        if ($tipoMovilidad->tipo == TipoMovilidad::DESVINCULADO || $tipoMovilidad->tipo == TipoMovilidad::RENUNCIA) {
            $movilidad->fecha_inicio = $request->fecha_termino;
        } else {
            $movilidad->fecha_inicio = $request->fecha_inicio;
        }

        $movilidad->tipoMovilidad()->associate($request->tipo_movilidad_id);
        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->colaborador()->associate($colaborador);

        $movilidad->save();

        return response()->json(null, 201);
    }
}
