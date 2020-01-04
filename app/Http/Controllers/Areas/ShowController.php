<?php

namespace App\Http\Controllers\Departamentos;

use App\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartamentoResource;

class ShowController extends Controller
{
    public function __invoke($id)
    {
        $departamento = Departamento::findOrFail($id);

        return new DepartamentoResource($departamento);
    }
}
