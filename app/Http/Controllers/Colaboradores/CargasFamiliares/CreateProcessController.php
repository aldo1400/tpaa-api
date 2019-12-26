<?php

namespace App\Http\Controllers\Colaboradores\CargasFamiliares;

use App\Colaborador;
use App\CargaFamiliar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CargaFamiliarRequest;

class CreateProcessController extends Controller
{
    public function __invoke(CargaFamiliarRequest $request, $id)
    {
        $colaborador = Colaborador::findOrFail($id);

        $cargaFamiliar = CargaFamiliar::make($request->validated());
        // dd($request->all());
        $cargaFamiliar->colaborador()->associate($colaborador->id);
        $cargaFamiliar->tipoCarga()->associate($request->tipo_carga_id);
        $cargaFamiliar->save();

        return response()->json(null, 201);
    }
}
