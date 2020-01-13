<?php

namespace App\Http\Controllers\Colaboradores\Movilidades;

use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
public function __invoke($id){
    $colaborador=Colaborador::findOrFail($id);
    
    $colaborador->cargoActual()
                ->delete();

    $movilidad=$colaborador->movilidades()
        ->orderBy('id', 'desc')
        ->first();

    $movilidad->update([
            'fecha_termino'=>null,
            'estado'=>1
        ]);

   return response()->json(); 
}
}
