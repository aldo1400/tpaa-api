<?php

namespace App\Http\Controllers\Capacitaciones;

use App\CursoColaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoColaboradorResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $cursoColaborador = CursoColaborador::findOrFail($id);

        return new CursoColaboradorResource($cursoColaborador);
    }
}
