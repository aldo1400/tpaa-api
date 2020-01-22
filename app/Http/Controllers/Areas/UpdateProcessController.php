<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, AreaRequest $request)
    {
        $area = Area::findOrFail($id);

        if(!$request->estado){
          $errors=[];
          $errors=$this->obtenerErrores($area);
          if(!empty($errors)){
            return response()->json($errors, 409);
          }
        }

        $area->update($request->validated());

        $area->padre()->associate($request->padre_id);
        $area->save();

      return response()->json();
    }

    public function obtenerErrores($area){
      $errors=[];
      if ($area->encontrarAreaInferior()) {
        array_push($errors,"El area tiene hijos.");
      }
      
      if($area->cargos()->count()){
        array_push($errors,"El area esta asociada a cargos.");
      }
      return $errors;
    }
}
