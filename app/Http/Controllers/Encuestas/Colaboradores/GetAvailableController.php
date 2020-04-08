<?php

namespace App\Http\Controllers\Encuestas\Colaboradores;

use App\Encuesta;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorShortResource;

class GetAvailableController extends Controller
{
    public function __invoke($id)
    {
        $encuesta = Encuesta::findOrFail($id);

        $colaboradores = $encuesta->colaboradores;

        // $colaboradores = collect();

        // foreach ($capacitaciones as $capacitacion) {
        //     $colaboradores->push($capacitacion->colaborador);
        // }

        $colaboradores = $colaboradores->pluck('id')->toArray();

        $colaboradoresDisponibles = Colaborador::whereNotIn('id', $colaboradores)
                                        ->where('estado', '1')
                                        ->get();

        return ColaboradorShortResource::collection($colaboradoresDisponibles);
    }
}
