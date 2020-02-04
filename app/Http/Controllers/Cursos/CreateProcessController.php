<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Http\Requests\CursoRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(CursoRequest $request)
    {
        $curso=Curso::make($request->validated());
        $curso->tipoCurso()->associate($request->tipo_curso_id);
        $curso->save();

        return response()->json(null, 201);
    }
}
