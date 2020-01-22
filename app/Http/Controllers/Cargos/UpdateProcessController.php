<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Requests\CargoRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $this->validate($request,[
            'nombre'=>'required|string',
            'supervisor_id'=>'required|exists:cargos,id'
        ]);

        $cargo = Cargo::findOrFail($id);

        if(!$request->estado){
            $errors=[];
            $errors=$this->obtenerErrores($area);
            if(!empty($errors)){
              return response()->json($errors, 409);
            }
          }

        $cargo->fill([
            'nombre'=>$request->nombre
        ]);
        $cargo->supervisor()->associate($request->supervisor_id);
        $cargo->save();

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
