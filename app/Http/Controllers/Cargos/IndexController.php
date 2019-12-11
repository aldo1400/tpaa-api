<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargoResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $cargos = Cargo::all();

        return CargoResource::collection($cargos);
    }
}
