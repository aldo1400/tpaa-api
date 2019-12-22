<?php

namespace App\Http\Controllers\Cursos;

use App\Curso;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $curso = Curso::findOrFail($id);
        $curso->delete();

        return response()->json();
    }
}
