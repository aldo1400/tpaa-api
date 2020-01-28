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
            $errors=$this->obtenerErrores($cargo);
            if(!empty($errors)){
              return response()->json($errors, 409);
            }
          }

          
        //   if ($request->imagen) {
        //     $colaborador->imagen_url = $colaborador->saveImage($request);
        // } else {
        //     if (!$request->imagen_url && $colaborador->imagen_url) {
        //         $ext = pathinfo($colaborador->imagen_url, PATHINFO_EXTENSION);

        //         $urlPath = 'public/colaboradores/imagenes/'.$colaborador->rut.'.'.$ext;

        //         Storage::delete($urlPath);
        //         $colaborador->imagen = null;
        //         $colaborador->imagen_url = null;
        //     }
        // }

        $cargo->fill([
            'nombre'=>$request->nombre
        ]);

        dd($cargo->descriptor_url);
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
