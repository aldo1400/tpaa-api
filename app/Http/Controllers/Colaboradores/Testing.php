<?php

namespace App\Http\Controllers\Colaboradores;

use App\Cargo;
use App\Movilidad;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorResource;

class Testing extends Controller
{
    public function __invoke($rut)
    {
        // dd($rut);
        $colaborador = Colaborador::where('rut', $rut)->first();
        $movilidad = Movilidad::where('colaborador_id', $colaborador->id)
                    ->where('estado', 1)
                    ->first();

        if (!$movilidad) {
            return $array_hijos = [];
        }

        $array_hijos = Cargo::where('supervisor_id', $movilidad->cargo_id)->get();

        if (count($array_hijos) == 0) {
            return 0;
        }

        $i = 0;

        while ($i < count($array_hijos)) {
            if (count($array_hijos) != 0) {
                $resultados_hijos = Cargo::where('supervisor_id', $array_hijos[$i]->id)->get();
            }

            if (count($resultados_hijos) > 0) {
                for ($j = 0; $j < count($resultados_hijos); ++$j) {
                    $array_hijos[count($array_hijos)] = $resultados_hijos[$j];
                }
            }
            ++$i;
        }

        $colaboradores = collect();
        $array_hijos = $array_hijos->where('estado', 1);
        foreach ($array_hijos as $hijo) {
            $movilidades = $hijo->movilidades()->where('estado', 1)->get();
            foreach ($movilidades as $movilidad) {
                $colaboradores->push($movilidad->colaborador);
            }
        }

        return ColaboradorResource::collection($colaboradores);
    }
}
