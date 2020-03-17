<?php

namespace App\Http\Controllers\Colaboradores\Consultas;

use App\Consulta;
use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultaRequest;

class CreateProcessController extends Controller
{
    public function __invoke(ConsultaRequest $request,$id)
    {
        $colaborador = Colaborador::findOrFail($id);

        $consulta = Consulta::make($request->validated());
        $consulta->tipoConsulta()->associate($request->tipo_consulta_id);
        $consulta->colaborador()->associate($colaborador);
        $consulta->save();

        return response()->json(null, 201);
    }
}
