<?php

namespace App\Http\Controllers\Colaboradores;

use App\Cargo;
use App\Movilidad;
use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Testing extends Controller
{
    public function __invoke($rut){
        // dd('hola');
        $colaborador = Colaborador::where('rut', $rut)->first();
        // dd($colaborador);
        $movilidad = Movilidad::where('colaborador_id', $colaborador->id)
                    ->where('estado', 1)
                    ->first();
// dd($movilidad);
        $array_hijos = Cargo::where('supervisor_id', $movilidad->cargo_id)->get();
        // dd($array_hijos);
        if(count($array_hijos) == 0)
            return 0;

        for($i=0; $i < count($array_hijos); $i++){
            // dd( $array_hijos[$i]->id);
            $resultados_hijos = Cargo::where('supervisor_id', $array_hijos[$i]->id)->get();
            // dd($resultados_hijos);
            if(count($resultados_hijos) > 0){
                // dd('xd');
                foreach($resultados_hijos as $hijos){
                    // dd($array_hijos);
                    array_push($array_hijos, $hijos);
                }
            }
        }

        dd($array_hijos);
        return response()->json();
    }
}
