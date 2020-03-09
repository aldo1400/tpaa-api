<?php

namespace App\Helpers;

use Carbon\Carbon;

class Date
{
    /**
     * @param Request $request
     *
     * @return string
     */
    public static function revisarFechaDeInicioYTermino($fecha_inicio, $fecha_termino): bool
    {
        if (!$fecha_inicio) {
            return true;
        }

        if (!$fecha_termino) {
            return true;
        }

        if (Carbon::parse($fecha_termino)->gt(Carbon::parse($fecha_inicio))) {
            return true;
        }

        return false;
    }
}
