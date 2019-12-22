<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Http\Requests\CursoRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(CursoRequest $request)
    {
        Curso::create($request->validated());

        return response()->json(null, 201);
    }
}
