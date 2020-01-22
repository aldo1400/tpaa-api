<?php

namespace App\Http\Controllers\Administradores;

use App\Administrador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AdministradorResource;

class IndexController extends Controller
{
    public function __invoke(){
        $administradores=Administrador::all();
        return AdministradorResource::collection($administradores);
    }
}
