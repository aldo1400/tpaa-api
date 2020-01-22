<?php

namespace App\Http\Controllers\Administradores;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdministradorRequest;

class UpdateProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request,[
            'nombre'=>'required|string|max:255',
            'username'=>'required|string|max:255',
            'estado'=>'required|boolean',
            'password'=>'nullable|confirmed'
        ]);

        $administrador=Auth::user();
        $administrador->fill($request->all());
        $administrador->password=Hash::make($request->password);

        $administrador->save();
        return response()->json();
    }
}
