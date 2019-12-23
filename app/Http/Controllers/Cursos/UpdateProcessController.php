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
        $curso->update($request->validated());

        return response()->json();
    }
}
