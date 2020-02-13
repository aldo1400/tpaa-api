<?php

namespace App\Http\Controllers\Colaboradores\Notificaciones;

use App\Colaborador;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificacionResource;

class IndexController extends Controller
{
    public function __invoke($id)
    {
        $colaborador = Colaborador::findOrFail($id);

        return NotificacionResource::collection($colaborador->notificaciones);
    }
}
