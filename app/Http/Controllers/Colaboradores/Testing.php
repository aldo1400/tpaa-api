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
        $colaborador = Colaborador::where('rut', $rut)->first();
        $movilidad = Movilidad::where('colaborador_id', $colaborador->id)
                    ->where('estado', 1)
                    ->first();
        $array_hijos = Cargo::where('supervisor_id', $movilidad->cargo_id)->get();
        
        if(count($array_hijos) == 0)
            return 0;
        
        $i=0;

        while( $i < count($array_hijos)){

            if(count($array_hijos) != 0){
                $resultados_hijos = Cargo::where('supervisor_id', $array_hijos[$i]->id)->get();
            }
            echo $i;
                      
            if(count($resultados_hijos) > 0){
                for($j=0;$j < count($resultados_hijos);$j++){
                    $array_hijos[count($array_hijos)]=$resultados_hijos[$j];
                }
            }
            $i++;
        }

        dd($array_hijos);
        return response()->json();
    }
}
