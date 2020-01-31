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
        
        if ($colaborador->movilidades()->count()) {
            $colaborador->cargoActual()
                        ->update([
                            'estado' => 0,
                            'fecha_termino' => $request->fecha_termino,
                        ]);
        }
     
        $tipoMovilidad = TipoMovilidad::findOrFail($request->tipo_movilidad_id);

        if(!$colaborador->movilidades()->count() && $tipoMovilidad->tipo!=TipoMovilidad::NUEVO)
        {
            return response()->json(['message'=>'El tipo de movilidad es inválido.'],409);
        }

        $movilidad = Movilidad::make([
            'observaciones' => $request->observaciones,
            'fecha_inicio'=>$request->fecha_inicio,
        ]);
        
        $colaborador->estado=1;

        if ($tipoMovilidad->tipo == TipoMovilidad::DESVINCULADO || $tipoMovilidad->tipo == TipoMovilidad::RENUNCIA)
        {
            $colaborador->estado=0;
            if($request->cargo_id){
                return response()->json(['message'=>'El cargo es inválido.'],409);
            }
        }

        $movilidad->tipoMovilidad()->associate($request->tipo_movilidad_id);
        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->colaborador()->associate($colaborador);
        
        $movilidad->save();
        $colaborador->save();

        return response()->json(null, 201);
    }
}
