<?php

namespace App\Http\Controllers\Areas;

use App\Imports\AreasImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new AreasImport(), 'public/Areas.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
