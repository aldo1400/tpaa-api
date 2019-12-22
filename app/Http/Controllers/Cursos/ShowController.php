<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $curso = Curso::findOrFail($id);

        return new CursoResource($curso);
    }
}
