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

        $cargo->fill([
            'nombre'=>$request->nombre
        ]);
        $cargo->supervisor()->associate($request->supervisor_id);
        $cargo->save();

        return response()->json();
    }
}
