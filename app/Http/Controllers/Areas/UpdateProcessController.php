<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use App\Http\Requests\AreaRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, AreaRequest $request)
    {
        $area = Area::findOrFail($id);

        $errors = [];
        $errors = $this->obtenerErrores($area);

        if (empty($errors)) {
            $area->tipoArea()->associate($request->tipo_area_id);
            $area->fill([
              'estado' => $request->estado,
            ]);
        } else {
            if (($request->estado!=$area->estado) || ($request->tipo_area_id != $area->tipo_area_id)) {
                return response()->json($errors, 409);
            }
        }

        $area->fill([
          'nombre' => $request->nombre,
        ]);

        $area->padre()->associate($request->padre_id);
        $area->save();

        return response()->json();
    }

    public function obtenerErrores($area)
    {
        $errors = [];
        if ($area->encontrarAreaInferior()) {
            array_push($errors, 'El area tiene hijos.');
        }

        if ($area->cargos()->count()) {
            array_push($errors, 'El area esta asociada a cargos.');
        }

        return $errors;
    }
}
