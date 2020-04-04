<?php

namespace App\Http\Controllers\Encuestas\Colaboradores;

use App\Encuesta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DeleteProcessController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $this->validate($request, [
            'colaboradores' => 'required|array',
            'colaboradores.*' => 'required|distinct|exists:colaboradores,id',
        ]);

        $encuesta = Encuesta::findOrFail($id);
        $encuesta->colaboradores()->detach($request->colaboradores);

        return response()->json();
    }
}
