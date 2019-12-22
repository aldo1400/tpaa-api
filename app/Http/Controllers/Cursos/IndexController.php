<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $cursos = Curso::all();

        return CursoResource::collection($cursos);
    }
}
