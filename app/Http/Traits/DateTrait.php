<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait DateTrait
{
    public function validarLimitesDeFecha($movilidades, $fecha_inicio, $fecha_termino)
    {
        $checkDate = true;
        foreach ($movilidades as $movilidad) {
            if ($movilidad->isActivo()) {
                if (Carbon::parse($movilidad->fecha_inicio)->lte(Carbon::parse($fecha_termino))) {
                    $checkDate = false;
                    break;
                }
                continue;
            }

            $check = Carbon::parse($fecha_inicio)->between(Carbon::parse($movilidad->fecha_inicio), Carbon::parse($movilidad->fecha_termino));
            if ($check) {
                $checkDate = false;
                break;
            }

            $checkTwo = Carbon::parse($fecha_termino)->between(Carbon::parse($movilidad->fecha_inicio), Carbon::parse($movilidad->fecha_termino));
            if ($checkTwo) {
                $checkDate = false;
                break;
            }

            $checkThree = Carbon::parse($movilidad->fecha_inicio)->between(Carbon::parse($fecha_inicio), Carbon::parse($fecha_termino));
            if ($checkThree) {
                $checkDate = false;
                break;
            }
        }

        return $checkDate;
    }
}
