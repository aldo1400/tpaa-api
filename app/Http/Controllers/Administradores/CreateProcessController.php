<?php

namespace App\Http\Controllers\Administradores;

use App\Administrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdministradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(AdministradorRequest $request){
        $administrador=Administrador::make($request->validated());
        $administrador->password=Hash::make($request->password);
        $administrador->save();
        return response()->json(null,201);
    }
}
