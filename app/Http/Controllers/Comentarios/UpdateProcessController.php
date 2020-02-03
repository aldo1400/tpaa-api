<?php

namespace App\Http\Controllers\Comentarios;

use App\Comentario;
use App\Http\Controllers\Controller;
use App\Http\Requests\ComentarioRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(ComentarioRequest $request, $id)
    {
        $comentario = Comentario::findOrFail($id);
        $comentario->fill($request->validated());
        $comentario->autor()->associate($request->colaborador_autor_id);
        $comentario->receptor()->associate($request->colaborador_id);
        $comentario->tipoComentario()->associate($request->tipo_comentario_id);
        $comentario->save();

        return response()->json();
    }
}
