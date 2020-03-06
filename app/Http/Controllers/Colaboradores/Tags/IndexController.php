<?php

namespace App\Http\Controllers\Colaboradores\Tags;

use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Resources\TagResource;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);

        if ($request->positivo) {
            $tags = $colaborador->tagsPositivos();
        } else {
            $tags = $colaborador->tags;
        }

        return TagResource::collection($tags);
    }
}
