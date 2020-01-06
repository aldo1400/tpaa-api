<?php

namespace App\Http\Controllers\Areas;

use App\Area;
use Illuminate\Http\Request;
use App\Http\Requests\AreaRequest;
use App\Http\Controllers\Controller;

class UpdateProcessController extends Controller
{
    public function __invoke($id, AreaRequest $request)
    {
        $area = Area::findOrFail($id);

        $area->update([
            'nombre' => $request->nombre,
        ]);

      return response()->json();
    }
}
