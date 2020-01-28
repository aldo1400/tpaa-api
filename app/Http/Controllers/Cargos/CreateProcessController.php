<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use App\Http\Requests\CargoRequest;
use App\Http\Controllers\Controller;

class CreateProcessController extends Controller
{
    public function __invoke(CargoRequest $request)
    {
        //TODO:Validar valor del padre
        $cargo = Cargo::make($request->validated());
        $cargo->supervisor()->associate($request->supervisor_id);
        $cargo->nivelJerarquico()->associate($request->nivel_jerarquico_id);
        $cargo->area()->associate($request->area_id);
        
        $cargo->save();
        
        $cargo->update([
            'organigrama_url' => $request->file('organigrama') ? $cargo->saveFile($request->file('organigrama'),'organigrama') : '',
            'descriptor_url' =>$request->file('descriptor') ? $cargo->saveFile($request->file('descriptor'),'descriptor') : ''
        ]);

        return response()->json(null, 201);
    }
}
