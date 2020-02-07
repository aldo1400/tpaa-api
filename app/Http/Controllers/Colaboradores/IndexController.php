<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColaboradorResource;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $colaboradores = Colaborador::all();

        if(!empty($request->estado)){
            if($request->estado=='true'){
                $colaboradores=Colaborador::where('estado','1')->get();
            }
            else{
                $colaboradores=Colaborador::where('estado','0')->get();
            }
        }

        return ColaboradorResource::collection($colaboradores);
    }
}
