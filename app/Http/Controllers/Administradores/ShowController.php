<?php

namespace App\Http\Controllers\Administradores;

use App\Administrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdministradorResource;

class ShowController extends Controller
{
    public function __invoke($id){
        $administrador=Administrador::findOrFail();
        return new AdministradorResource($administrador);
    }
}
