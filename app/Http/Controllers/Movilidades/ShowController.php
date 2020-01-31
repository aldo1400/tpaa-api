<?php

namespace App\Http\Controllers\Movilidades;

use App\Movilidad;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MovilidadResource;

class ShowController extends Controller
{
    public function __invoke($id){
        $movilidad=Movilidad::findOrFail($id);
        return new MovilidadResource($movilidad);
    }
}
