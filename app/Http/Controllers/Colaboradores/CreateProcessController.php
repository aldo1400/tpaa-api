<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use App\Departamento;
use Freshwork\ChileanBundle\Rut;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ColaboradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(ColaboradorRequest $request)
    {
        $colaborador = Colaborador::make($request->validated());

        $colaborador->rut = $request->rut;
        $colaborador->password = Hash::make($request->password);

        if (!(Rut::parse($request->rut)->quiet()->validate())) {
            return response()->json(['message' => 'El rut es inválido.'], 409);
        }

        if ($request->departamento_id) {
            $departamento = Departamento::findOrFail($request->departamento_id);
            $colaborador->definirDepartamento($departamento);
        }

        $colaborador->save();

        return response()->json(null, 201);
    }
}
