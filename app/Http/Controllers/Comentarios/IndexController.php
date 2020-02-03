<?php

namespace App\Http\Controllers\Comentarios;

use App\Comentario;
use App\Http\Controllers\Controller;
use App\Http\Resources\ComentarioResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $comentarios = Comentario::all();

        return ComentarioResource::collection($comentarios);
    }
}
