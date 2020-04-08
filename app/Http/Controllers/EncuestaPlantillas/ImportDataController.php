<?php

namespace App\Http\Controllers\EncuestaPlantillas;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EncuestaPlantillasImport;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new EncuestaPlantillasImport(), 'public/EncuestaPlantillas.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
