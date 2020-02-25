<?php

namespace App\Http\Controllers\Cargos;

use App\Imports\CargosImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new CargosImport(), 'public/Cargos.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
