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
        $colaborador->imagen_url = $request->imagen ? $colaborador->saveImage($request) : $colaborador->imagen_url;
        $colaborador->nivelEducacion()->associate($request->nivel_educacion_id);
        $colaborador->estadoCivil()->associate($request->estado_civil_id);
        $colaborador->save();

        $colaborador->tags()->sync($request->tags);

        return response()->json();
    }
}
