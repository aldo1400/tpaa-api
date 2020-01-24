<?php

namespace App\Http\Controllers\Colaboradores;

use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DeleteImageController extends Controller
{
    public function __invoke($id){
        $colaborador=Colaborador::findOrFail($id);

        $ext = pathinfo($colaborador->imagen_url, PATHINFO_EXTENSION);

        $urlPath='public/colaboradores/imagenes/'.$colaborador->rut.'.'.$ext;
        
        Storage::delete($urlPath);

        $colaborador->imagen=null;
        $colaborador->imagen_url=null;
        $colaborador->save();
        return response()->json();
    }
}
