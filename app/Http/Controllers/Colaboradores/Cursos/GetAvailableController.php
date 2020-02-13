<?php

namespace App\Http\Controllers\Colaboradores\Cursos;

use App\Curso;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoResource;

class GetAvailableController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        $capacitaciones = $colaborador->capacitaciones;

        $cursos = collect();

        foreach ($capacitaciones as $capacitacion) {
            $cursos->push($capacitacion->curso);
        }

        $cursos = $cursos->pluck('id')->toArray();

        $cursosDisponibles = Curso::whereNotIn('id', $cursos)->where('estado', 1)->get();

        return CursoResource::collection($cursosDisponibles);
    }
}
