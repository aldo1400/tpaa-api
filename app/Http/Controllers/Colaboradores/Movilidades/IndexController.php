<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovilidadResource;

class IndexController extends Controller
{
    public function __invoke($id){
        $colaborador=Colaborador::findOrFail($id);
        return MovilidadResource::collection($colaborador->movilidades->sortByDesc('id'));
    }
}
