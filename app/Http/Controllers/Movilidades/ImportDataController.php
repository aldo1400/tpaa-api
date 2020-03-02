<?php

namespace App\Http\Controllers\Movilidades;

use App\Imports\MovilidadesImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new MovilidadesImport(), 'public/Movilidades.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
