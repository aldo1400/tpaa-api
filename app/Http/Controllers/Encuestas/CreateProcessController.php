<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Http\Controllers\Controller;
use App\Http\Requests\EncuestaRequest;

class CreateProcessController extends Controller
{
    public function __invoke(EncuestaRequest $request)
    {
        $encuesta = Encuesta::make($request->validated());
        $encuesta->periodo()->associate($request->periodo_id);
        $encuesta->save();

        return response()->json(null, 201);
    }
}
