<?php

namespace App\Http\Controllers\CursosColaborador;

use App\Helpers\Image;
use App\CursoColaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CursoColaboradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(CursoColaboradorRequest $request){
        
        $cursoColaborador=CursoColaborador::make([
            'fecha' => $request->fecha,
            'estado' => $request->estado,
            'tipo_archivo' => $request->tipo_archivo,
            'diploma' => Image::convertImage($request),
        ]);

        $cursoColaborador->curso()->associate($request->curso_id);
        $cursoColaborador->colaborador()->associate($request->colaborador_id);
        $cursoColaborador->save();

        return response()->json(null,201);
    }
}
