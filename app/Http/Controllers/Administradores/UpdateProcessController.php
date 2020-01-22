<?php

namespace App\Http\Controllers\Administradores;

use App\Administrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdministradorRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(AdministradorRequest $request,$id){
        $administrador=Administrador::findOrFail($id);
        $administrador->fill($request->validated());
        
        if($request->password){
            $administrador->password=Hash::make($request->password);
        }

        $administrador->save();
        // dd($administrador);
        return response()->json();
    }
}
