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
            'supervisor_id'=>'required|exists:cargos,id',
            'descriptor'=>'nullable|file',
            'descriptor_url'=>'nullable|string',
            'organigrama'=>'nullable|file',
            'organigrama_url'=>'nullable|string'
        ]);

        $cargo = Cargo::findOrFail($id);

        if(!$request->estado){
            $errors=[];
            $errors=$this->obtenerErrores($cargo);
            if(!empty($errors)){
              return response()->json($errors, 409);
            }
          }

        $cargo->fill([
            'nombre'=>$request->nombre
        ]);

        $cargo->actualizarArchivo($request,'descriptor');
        $cargo->actualizarArchivo($request,'organigrama');

        $cargo->supervisor()->associate($request->supervisor_id);
        $cargo->save();

        return response()->json();
    }

    public function obtenerErrores($cargo){
        $errors=[];
        if ($cargo->encontrarCargoInferior()) {
          array_push($errors,"El cargo tiene hijos.");
        }
        
        if($cargo->movilidades()->where('estado',1)->count()){
          array_push($errors,"El cargo esta asociada a movilidades.");
        }

        return $errors;
      }
}
