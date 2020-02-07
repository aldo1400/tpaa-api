<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $this->validate($request, [
            'nombre' => 'required|string',
            'supervisor_id' => 'nullable|exists:cargos,id',
            'descriptor' => 'nullable|file',
            'descriptor_url' => 'nullable|string',
            'organigrama' => 'nullable|file',
            'organigrama_url' => 'nullable|string',
            'area_id' => 'required|exists:areas,id',
            'nivel_jerarquico_id' => 'required|exists:niveles_jerarquico,id',
            'supervisor_id' => 'nullable|exists:cargos,id',
            'estado' => 'required|boolean',
            'nombre_fantasia'=>'nullable|string'
        ]);

        $cargo = Cargo::findOrFail($id);
         
        $errors = [];
        $errors = $this->obtenerErrores($cargo);

        if (empty($errors)) {
            $cargo->supervisor()->associate($request->supervisor_id);
            $cargo->fill([
              'estado' => $request->estado,
            ]);
        } else {
          
            if (!$request->estado || ($request->supervisor_id != $cargo->supervisor_id)) {
                return response()->json($errors, 409);
            }
        }

        $cargo->fill([
            'nombre' => $request->nombre,
            'nombre_fantasia'=>$request->nombre_fantasia
        ]);

        $cargo->actualizarArchivo($request, 'descriptor');
        $cargo->actualizarArchivo($request, 'organigrama');

        $cargo->area()->associate($request->area_id);
        $cargo->nivelJerarquico()->associate($request->nivel_jerarquico_id);
        $cargo->save();

        return response()->json();
    }

    public function obtenerErrores($cargo)
    {
        $errors = [];
        if ($cargo->encontrarCargoInferior()) {
            array_push($errors, 'El cargo tiene hijos.');
        }

        if ($cargo->movilidades()->where('estado', 1)->count()) {
            array_push($errors, 'El cargo esta asociada a movilidades.');
        }

        return $errors;
    }
}
