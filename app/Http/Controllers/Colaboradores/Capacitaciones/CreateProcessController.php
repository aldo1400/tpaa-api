<?php

namespace App\Http\Controllers\Colaboradores\Capacitaciones;

use App\Curso;
use App\Colaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class CreateProcessController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $this->validate($request, [
            'diploma' => 'required|file',
            // 'diploma' => 'required|image|mimes:jpeg,bmp,png',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $colaborador = Colaborador::findOrFail($id);
        $curso = Curso::findOrFail($request->curso_id);

        $extensiones = ['bmp', 'png', 'jpeg'];
        $extensionFile = $request->file('diploma')
                            ->extension();

        if (in_array($extensionFile, $extensiones)) {
            Image::make(file_get_contents($request->file('diploma')->getRealPath()))
                        ->encode($request->file('diploma')->extension(), 75);
        }

        $file = $request->diploma;

        $curso->crearCapacitacion($colaborador->id, $file);

        return response()->json(null, 201);
    }
}
