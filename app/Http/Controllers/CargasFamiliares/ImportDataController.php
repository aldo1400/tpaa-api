<?php

namespace App\Http\Controllers\CargasFamiliares;

use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CargasFamiliaresImport;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        try {
            // $import->import('import-users.xlsx');
            Excel::import(new CargasFamiliaresImport(), 'public/CargasFamiliares.xlsx');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            foreach ($failures as $failure) {
                $failure->row(); // row that went wrong
                $failure->attribute(); // either heading key (if using heading row concern) or column index
                $failure->errors(); // Actual error messages from Laravel validator
                $failure->values(); // The values of the row that has failed.
            }
            dd($failures);
        }

        return redirect('/')->with('success', 'All good!');
    }
}
