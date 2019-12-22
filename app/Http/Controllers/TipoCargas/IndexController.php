<?php

namespace App\Http\Controllers\TipoCargas;

use App\TipoCarga;
use App\Http\Controllers\Controller;
use App\Http\Resources\TipoCargaResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $tipoCargas = TipoCarga::all();

        return TipoCargaResource::collection($tipoCargas);
    }
}
