<?php

namespace App\Observers;

use App\Movilidad;

class MovilidadObserver
{
    /**
     * Handle the movilidad "created" event.
     *
     * @param \App\Movilidad $movilidad
     */
    public function created(Movilidad $movilidad)
    {
        $colaborador = $movilidad->colaborador;
        if ($movilidad->isTipoExcluyente()) {
            $colaborador->estado = 0;
        } else {
            $colaborador->estado = 1;
        }

        $colaborador->save();

        return true;
    }

    /**
     * Handle the movilidad "updated" event.
     *
     * @param \App\Movilidad $movilidad
     */
    public function updated(Movilidad $movilidad)
    {
    }

    /**
     * Handle the movilidad "deleted" event.
     *
     * @param \App\Movilidad $movilidad
     */
    public function deleted(Movilidad $movilidad)
    {
    }

    /**
     * Handle the movilidad "restored" event.
     *
     * @param \App\Movilidad $movilidad
     */
    public function restored(Movilidad $movilidad)
    {
    }

    /**
     * Handle the movilidad "force deleted" event.
     *
     * @param \App\Movilidad $movilidad
     */
    public function forceDeleted(Movilidad $movilidad)
    {
    }
}
