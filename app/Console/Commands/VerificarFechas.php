<?php

namespace App\Console\Commands;

use App\Colaborador;
use Illuminate\Console\Command;

class VerificarFechas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'colaboradores:vencimiento';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Verificar la fecha de vencimiento de licencia b , licencia d y carnet_portuario de un colaborador';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $colaboradores = Colaborador::all();

        foreach ($colaboradores as $colaborador) {
            $colaborador->revisarFechaVencimiento('vencimiento_licencia_b');
            $colaborador->revisarFechaVencimiento('vencimiento_licencia_d');
            $colaborador->revisarFechaVencimiento('vencimiento_carnet_portuario');
            $colaborador->revisarFechaVencimiento('vencimiento_credencial_vigilante');
        }
    }
}
