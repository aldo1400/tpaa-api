<?php

namespace App\Http\Controllers\CargasFamiliares;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CargasFamiliaresImport;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new CargasFamiliaresImport(), 'public/CargasFamiliares.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
