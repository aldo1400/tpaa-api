<?php

namespace App\Http\Controllers\Capacitaciones;

use App\Curso;
use App\CursoColaborador;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class UpdateProcessController extends Controller
{
    public function __invoke(Request $request, $id)
    {
        $this->validate($request, [
            'diploma' => 'nullable|file',
            'curso_id' => 'required|exists:cursos,id',
        ]);

        $capacitacion = CursoColaborador::findOrFail($id);
        $curso = Curso::findOrFail($request->curso_id);

        if ($request->diploma) {
            $extensiones = ['bmp', 'png', 'jpeg'];
            $extensionFile = $request->file('diploma')
                                ->extension();

            if (in_array($extensionFile, $extensiones)) {
                Image::make(file_get_contents($request->file('diploma')->getRealPath()))
                                ->encode($request->file('diploma')->extension(), 75);
            }
        }

        $capacitacion->actualizarArchivo($request, 'diploma');
        $capacitacion->curso()->associate($request->curso_id);
        $capacitacion->save();

        return response()->json();
    }
}
