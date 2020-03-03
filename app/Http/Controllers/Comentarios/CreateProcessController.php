<?php

namespace App\Http\Controllers\Comentarios;

use App\Comentario;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComentarioRequest;

class CreateProcessController extends Controller
{
    public function __invoke(ComentarioRequest $request)
    {
        $comentario = Comentario::make($request->validated());

        $colaboradorReceptor = Colaborador::findOrFail($request->colaborador_id);

        $primeraMovilidad = $colaboradorReceptor->movilidades
                            ->first();

        if (!$primeraMovilidad) {
            return response()->json([
                'message' => 'Primero debe asignarle un Cargo al Colaborador.',
            ], 409);
        }

        if ($primeraMovilidad->fecha_inicio->gt($request->fecha)) {
            return response()->json([
                'message' => 'La fecha del comentario debe ser posterior a la Fecha de Inicio del Cargo del Colaborador.',
            ], 409);
        }

        $comentario->autor()->associate($request->colaborador_autor_id);
        $comentario->receptor()->associate($request->colaborador_id);
        $comentario->tipoComentario()->associate($request->tipo_comentario_id);
        $comentario->save();

        return response()->json(null, 201);
    }
}
