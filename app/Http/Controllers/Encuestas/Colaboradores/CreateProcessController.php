<?php

namespace App\Http\Controllers\Encuestas\Colaboradores;

use App\Encuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $encuesta = Encuesta::findOrFail($id);
        // $request->users =
        $datos = [];
        // dd($request->colaboradores);
        foreach ($request->colaboradores as $colaborador) {
            $datos[$colaborador] = ['valory' => 'vasdasalue'];
        }
        dd($datos);
        // $colaborador->tags()->sync($request->);
    }
}
