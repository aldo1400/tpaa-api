<?php

namespace App\Http\Controllers\Cursos\Colaboradores;

use App\Curso;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorResource;

class GetAvailableController extends Controller
{
    public function __invoke($id)
    {
        $curso = Curso::findOrFail($id);

        $capacitaciones = $curso->capacitaciones;

        $colaboradores = collect();

        foreach ($capacitaciones as $capacitacion) {
            $colaboradores->push($capacitacion->colaborador);
        }

        $colaboradores = $colaboradores->pluck('id')->toArray();

        $colaboradoresDisponibles = Colaborador::whereNotIn('id', $colaboradores)->where('estado','1')->get();

        return ColaboradorResource::collection($colaboradoresDisponibles);
    }
}
