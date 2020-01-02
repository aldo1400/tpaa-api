<?php

namespace App\Http\Controllers\NivelesJerarquico;

use App\NivelJerarquico;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NivelJerarquicoRequest;

class CreateProcessController extends Controller
{
    public function __invoke(NivelJerarquicoRequest $request){
        NivelJerarquico::create($request->validated());
        return response()->json(null,201);
    }
}
