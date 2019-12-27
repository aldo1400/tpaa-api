<?php

namespace App\Http\Controllers\CargasFamiliares;

use App\CargaFamiliar;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id){
        $cargaFamiliar = CargaFamiliar::findOrFail($id);
        $cargaFamiliar->delete();
        
        return response()->json();
    }
}
