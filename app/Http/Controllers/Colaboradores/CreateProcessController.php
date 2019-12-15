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

        $colaborador->password = Hash::make($request->password);

        if (!(Rut::parse($request->rut)->validate())) {
            return response()->json(['message' => 'El rut es inválido.'], 409);
        }

        if ($request->departamento_id) {
            $departamento = Departamento::findOrFail($request->departamento_id);
            if ($departamento->tipo == 'Gerencia General' || $departamento->tipo == 'Gerencia') {
                $colaborador->gerencia()->associate($request->departamento_id);
            } elseif ($departamento->tipo == 'Subgerencia') {
                $colaborador->subgerencia()->associate($request->departamento_id);
            } elseif ($departamento->tipo == 'Área') {
                $colaborador->area()->associate($request->departamento_id);
            } elseif ($departamento->tipo == 'Subarea') {
                $colaborador->subarea()->associate($request->departamento_id);
            } else {
            }
        }

        $colaborador->save();

        return response()->json(null, 201);
    }
}
