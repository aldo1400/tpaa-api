<?php

namespace App\Http\Controllers\Comentarios;

use App\Comentario;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComentarioResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $comentario = Comentario::findOrFail($id);

        return new ComentarioResource($comentario);
    }
}
