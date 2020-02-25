<?php

namespace App\Http\Controllers\Cursos;

use App\Imports\CursosImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new CursosImport(), 'public/Cursos.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
