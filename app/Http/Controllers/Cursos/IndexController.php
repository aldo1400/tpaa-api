<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursoResource;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $cursos = Curso::all();

        if (!empty($request->estado)) {
            if ($request->estado == 'true') {
                $cursos = Curso::where('estado', 1)->get();
            } else {
                $cursos = Curso::where('estado', 0)->get();
            }
        }

        return CursoResource::collection($cursos);
    }
}
