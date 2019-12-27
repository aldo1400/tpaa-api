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
        
        $cargaFamiliar->fill([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'estado' => $request->estado,
        ]);

        $cargaFamiliar->colaborador()->associate($request->colaborador_id);
        $cargaFamiliar->tipoCarga()->associate($request->tipo_carga_id);
        $cargaFamiliar->save();

        return response()->json();
    }
}
