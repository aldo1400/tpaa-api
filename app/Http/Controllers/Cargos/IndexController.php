<?php

namespace App\Http\Controllers\Cargos;

use App\Cargo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CargoResource;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $cargos = Cargo::all();

        if(!empty($request->estado)){
            if($request->estado=='true'){
                $cargos=Cargo::where('estado',1)->get();
            }
            else{
                $cargos=Cargo::where('estado',0)->get();
            }
        }

        return CargoResource::collection($cargos);
    }
}
