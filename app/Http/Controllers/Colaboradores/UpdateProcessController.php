<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Departamento;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColaboradorRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(ColaboradorRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);
        $colaborador->fill($request->validated());

        $tipoDepartamento = $colaborador->obtenerTipoDepartamento();

        if (empty($request->departamento_id)) {
            // $colaborador->$tipoDepartamento.'()'->associate($request->departamento_id);
            $association = $tipoDepartamento.'_id';
            $colaborador->$association = null;
            $colaborador->save();
        } else {
            if ($tipoDepartamento) {
                $association = $tipoDepartamento.'_id';
                $colaborador->$association = null;
                $colaborador->save();
            }
            $departamento = Departamento::findOrFail($request->departamento_id);
            $colaborador->definirDepartamento($departamento);
        }

        $colaborador->save();

        return response()->json();
    }
}
