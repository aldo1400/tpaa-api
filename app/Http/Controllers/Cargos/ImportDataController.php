<?php

namespace App\Http\Controllers\Cargos;

use App\Imports\CargosImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        $idUsuario = 2;

        Excel::import(new CargosImport($idUsuario), 'public/Cargos.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
