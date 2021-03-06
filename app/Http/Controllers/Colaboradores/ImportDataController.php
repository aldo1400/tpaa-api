<?php

namespace App\Http\Controllers\Colaboradores;

use App\Http\Controllers\Controller;
use App\Imports\ColaboradoresImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        ini_set('memory_limit', '1000M');
        ini_set('max_execution_time', 3600);

        Excel::import(new ColaboradoresImport(), 'public/Colaboradores.xlsx');

        return redirect('/')->with('success', 'All good GOOD GOOD!');
    }
}
