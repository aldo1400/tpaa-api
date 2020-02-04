<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AreaResource;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $areas = Area::all();
        
        if(!empty($request->estado)){
            if($request->estado=='true'){
                $areas=Area::where('estado',1)->get();
            }
            else{
                $areas=Area::where('estado',0)->get();
            }
        }

        return AreaResource::collection($areas);
    }
}
