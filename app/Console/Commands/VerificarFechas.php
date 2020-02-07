<?php

namespace App\Console\Commands;

use App\TipoCurso;
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
     *
     * @return void
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
        TipoCurso::create([
            'categoria'=>'TESTING TESTING'
        ]);
    }
}
