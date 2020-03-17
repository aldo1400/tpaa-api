<?php

namespace App\Http\Controllers\Consultas;

use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultaRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(ConsultaRequest $request, $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->fill($request->validated());
        $consulta->tipoConsulta()->associate($request->tipo_consulta_id);
        $consulta->colaborador()->associate($request->colaborador_id);
        $consulta->save();

        return response()->json(null, 201);
    }
}
