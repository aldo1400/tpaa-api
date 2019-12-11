<?php

namespace App\Http\Controllers\Departamentos;

use App\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Resources\DepartamentoResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $departamentos = Departamento::all();

        return DepartamentoResource::collection($departamentos);
    }
}
