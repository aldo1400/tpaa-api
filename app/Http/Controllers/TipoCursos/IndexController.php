<?php

namespace App\Http\Controllers\TipoCursos;

use App\TipoCurso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoCursoResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tipoCursos = TipoCurso::all();

        return TipoCursoResource::collection($tipoCursos);
    }
}
