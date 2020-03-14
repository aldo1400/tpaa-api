<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Helpers\Date;
use App\Http\Requests\CursoRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke(CursoRequest $request, $id)
    {
        if (!Date::revisarFechaDeInicioYTermino($request->fecha_inicio, $request->fecha_termino)) {
            return response()->json([
                    'message' => 'Fecha de termino debe ser mayor a la fecha de inicio del curso.',
                    'errors' => [
                        'fecha_inicio' => 'Fecha inválida.',
                        'fecha_termino' => 'Fecha inválida.',
                    ],
                ], 409);
        }

        $curso = Curso::findOrFail($id);
        $curso->fill($request->validated());
        $curso->tipoCurso()->associate($request->tipo_curso_id);
        $curso->save();

        return response()->json();
    }
}
