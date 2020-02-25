<?php

namespace App\Http\Controllers\Tags;

use App\Imports\TagsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class ImportDataController extends Controller
{
    public function __invoke()
    {
        Excel::import(new TagsImport(), 'public/Tags.xlsx');

        return redirect('/')->with('success', 'All good!');
    }
}
