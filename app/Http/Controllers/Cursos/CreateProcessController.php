<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use Carbon\Carbon;
use App\Http\Requests\CursoRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(CursoRequest $request)
    {
        if ($request->fecha_inicio && $request->fecha_termino) {
            if (Carbon::parse($request->fecha_termino)->lt(Carbon::parse($request->fecha_inicio))) {
                return response()->json([
                    'message' => 'Fecha de termino debe ser mayor a la fecha de inicio del curso.',
                    'errors' => [
                        'fecha_inicio' => 'Fecha inválida.',
                        'fecha_termino' => 'Fecha inválida.',
                    ],
                ], 409);
            }
        }

        $curso = Curso::make($request->validated());
        $curso->tipoCurso()->associate($request->tipo_curso_id);
        $curso->save();

        return response()->json(null, 201);
    }
}
