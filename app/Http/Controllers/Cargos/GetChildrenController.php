<?php

namespace App\Http\Controllers\Cargos;

use App\Http\Controllers\Controller;

class GetChildrenController extends Controller
{
    public function __invoke($id)
    {
        $array_hijos = Cargo::where('supervisor_id', $id)->get();

        if (count($array_hijos) == 0) {
            return 0;
        }

        $i = 0;

        while ($i < count($array_hijos)) {
            if (count($array_hijos) != 0) {
                $resultados_hijos = Cargo::where('supervisor_id', $array_hijos[$i]->id)->get();
            }
            echo $i;

            if (count($resultados_hijos) > 0) {
                for ($j = 0; $j < count($resultados_hijos); ++$j) {
                    $array_hijos[count($array_hijos)] = $resultados_hijos[$j];
                }
            }
            ++$i;
        }

        // dd($array_hijos);

        return CargoResource::collection($array_hijos);
    }
}
