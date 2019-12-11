<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Requests\CargoRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(CargoRequest $request)
    {
        //TODO:Validar valor del padre
        $cargo = Cargo::make($request->validated());
        $cargo->supervisor()->associate($request->supervisor_id);

        $cargo->save();

        return response()->json(null, 201);
    }
}
