<?php

namespace App\Http\Controllers\Preguntas;

use App\Imports\PreguntasImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new PreguntasImport(), 'public/Pregunta2.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
