<?php

namespace App\Http\Controllers\Capacitaciones;

use App\Curso;
use App\Helpers\Image;
use App\CursoColaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CursoColaboradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(CursoColaboradorRequest $request, $id)
    {
        $curso = Curso::findOrFail($id);

        // $curso->guardarColaboradores($request->colaborador);

        $cursoColaborador = CursoColaborador::make([
            'diploma' => Image::convertImage($request->diploma),
        ]);

        $cursoColaborador->url_diploma = $curso->saveFile($request->diploma);

        $cursoColaborador->curso()->associate($curso->id);
        $cursoColaborador->colaborador()->associate($request->colaborador_id);
        $cursoColaborador->save();

        return response()->json(null, 201);
    }
}
