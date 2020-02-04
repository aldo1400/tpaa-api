<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Http\Requests\CursoRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke(CursoRequest $request, $id)
    {
        $curso = Curso::findOrFail($id);
        $curso->fill($request->validated());
        $curso->tipoCurso()->associate($request->tipo_curso_id);
        $curso->save();

        return response()->json();
    }
}
