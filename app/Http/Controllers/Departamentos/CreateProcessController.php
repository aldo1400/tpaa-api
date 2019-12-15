<?php

namespace App\Http\Controllers\Departamentos;

use App\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Requests\DepartamentoRequest;

class CreateProcessController extends Controller
{
    public function __invoke(DepartamentoRequest $request)
    {
        //TODO:Validar valor del padre
        $departamento = Departamento::make($request->validated());

        $departamento->padre()->associate($request->padre_id);

        $departamento->save();

        return response()->json(null, 201);
    }
}
