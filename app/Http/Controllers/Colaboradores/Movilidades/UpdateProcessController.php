<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id){
        $movilidad=Movilidad::findOrFail($id);
        
        $movilidad->fill([
            'fecha_inicio'=>$request->fecha_inicio,
            'observaciones'=>$request->observaciones
        ]);

        if(!$movilidad->estado){
            $movilidad->fill([
                'fecha_termino'=>$request->fecha_termino,
            ]);
        }

        if($movilidad->tipoMovilidad->tipo==TipoMovilidad::RENUNCIA || $movilidad->tipoMovilidad->tipo==TipoMovilidad::DESVINCULADO){
            if($request->cargo_id){
                return response()->json(['message'=>'El tipo de movilidad es inválido.'],409);
            }
        }

        $movilidad->cargo()->associate($request->cargo_id);
        $movilidad->save();
        return response()->json();
    }
}
