<?php

namespace App\Http\Controllers\NivelesJerarquico;

use App\NivelJerarquico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NivelJerarquicoResource;

class IndexController extends Controller
{
    public function __invoke(){
        $nivelesJerarquico=NivelJerarquico::all();
        return NivelJerarquicoResource::collection($nivelesJerarquico);
    }
}
