<?php

namespace App\Http\Controllers\CargasFamiliares;

use App\CargaFamiliar;
use App\Http\Controllers\Controller;
use App\Http\Requests\CargaFamiliarRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(CargaFamiliarRequest $request, $id)
    {
        $cargaFamiliar = CargaFamiliar::findOrFail($id);
        $cargaFamiliar->fill($request->validated());
        $cargaFamiliar->colaborador()->associate($request->colaborador_id);
        $cargaFamiliar->save();

        return response()->json();
    }
}
