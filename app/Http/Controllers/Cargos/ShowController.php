<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargoResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $cargo = Cargo::findOrFail($id);

        return new CargoResource($cargo);
    }
}
