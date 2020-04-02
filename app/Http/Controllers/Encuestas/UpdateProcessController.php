<?php

namespace App\Http\Controllers\Encuestas;

use App\Http\Controllers\Controller;
use App\Http\Requests\EncuestaRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(EncuestaRequest $request, $id)
    {
        $encuesta = Encuesta::findOrFail($id);
        $encuesta->update($request->validated());

        return response()->json();
    }
}
