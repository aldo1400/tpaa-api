<?php

namespace App\Http\Controllers\Colaboradores;

use Illuminate\Http\Request;
use Freshwork\ChileanBundle\Rut;
use App\Http\Controllers\Controller;

class ValidateRutController extends Controller
{
    public function __invoke(Request $request)
    {
        $this->validate($request, [
            'rut' => 'required|string',
        ]);

        if (!(Rut::parse($request->rut)->quiet()->validate())) {
            return response()->json(['message' => 'El rut es inválido.'], 409);
        }

        return response()->json();
    }
}
