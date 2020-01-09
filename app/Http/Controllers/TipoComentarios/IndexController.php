<?php

namespace App\Http\Controllers\TipoComentarios;

use App\TipoComentario;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoComentarioResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tipoComentarios = TipoComentario::all();

        return TipoComentarioResource::collection($tipoComentarios);
    }
}
