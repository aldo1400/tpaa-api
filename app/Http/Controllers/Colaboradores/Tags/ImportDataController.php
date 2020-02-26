<?php

namespace App\Http\Controllers\Colaboradores\Tags;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TagsColaboradorImport;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        ini_set('memory_limit', '1000M');
        ini_set('max_execution_time', 3600);

        Excel::import(new TagsColaboradorImport(), 'public/TagColaborador.xlsx');

        return redirect('/')->with('success', 'All good GOOD GOOD!');
    }
}
