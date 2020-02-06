<?php

namespace App\Http\Controllers\Capacitaciones;

use App\CursoColaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke($id){
        $capacitacion=CursoColaborador::findOrFail($id);
        $capacitacion->delete();
        return response()->json();
    }
}
