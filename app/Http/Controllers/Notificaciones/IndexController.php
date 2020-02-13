<?php

namespace App\Http\Controllers\Notificaciones;

use App\Notificacion;
use App\Http\Controllers\Controller;
use App\Http\Resources\NotificacionResource;

class IndexController extends Controller
{
    public function __invoke()
    {
        $notificaciones = Notificacion::all();

        return NotificacionResource::collection($notificaciones);
    }
}
