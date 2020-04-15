<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Http\Controllers\Controller;
use App\Http\Requests\EncuestaRequest;

class UpdateProcessController extends Controller
{
    public function __invoke(EncuestaRequest $request, $id)
    {
        $encuesta = Encuesta::findOrFail($id);

        // dd($encuesta->colaboradores);
        if ($encuesta->colaboradores->count() && $request->encuesta_facil_id) {
            return response()->json(['message' => 'La encuesta esta relacionada con colaboradores.'], 409);
        }

        $encuesta->update([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
            'encuesta_facil_id' => $request->encuesta_facil_id ? $request->encuesta_facil_id : $encuesta->encuesta_facil_id,
        ]);

        return response()->json();
    }
}
