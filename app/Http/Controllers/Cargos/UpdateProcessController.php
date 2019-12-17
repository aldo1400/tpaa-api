<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Requests\CargoRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, CargoRequest $request)
    {
        $cargo = Cargo::findOrFail($id);

        $cargo->fill($request->validated());
        $cargo->supervisor()->associate($request->supervisor_id);
        $cargo->save();

        return response()->json();
    }
}
