<?php

namespace App\Http\Controllers\Encuestas;

use App\Encuesta;
use App\Respuesta;
use App\DetalleRespuesta;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id)
    {
        $encuesta = Encuesta::findOrFail($id);

        $detalleRespuestas = $encuesta->detalleRespuestas;

        $encuesta->colaboradores()->detach();

        Respuesta::whereIn('detalle_respuesta_id', $detalleRespuestas->pluck('id'))->delete();

        DetalleRespuesta::where('encuesta_id', $encuesta->id)->delete();

        $encuesta->delete();

        return response()->json();
    }
}
