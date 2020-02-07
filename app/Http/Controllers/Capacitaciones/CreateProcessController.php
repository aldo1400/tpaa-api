<?php

namespace App\Http\Controllers\Capacitaciones;

use App\Curso;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;
use App\Http\Requests\CursoColaboradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(CursoColaboradorRequest $request, $id)
    {
        $curso = Curso::findOrFail($id);

        DB::transaction(function () use ($curso,$request) {
            foreach ($request->colaboradores as $colaborador) {
                if (count($request->colaboradores) == 1) {
                    $extensiones = ['bmp', 'png', 'jpeg'];
                    $extensionFile = $request->file('diploma')->extension();
                    if (in_array($extensionFile, $extensiones)) {
                        Image::make(file_get_contents($request->file('diploma')->getRealPath()))
                        ->encode($request->file('diploma')->extension(), 75);
                    }
                    $file = $request->diploma;
                } else {
                    // $pdf = PDF::loadView('capacitacion.diploma', []);
                    $content = $pdf->download()->getOriginalContent();
                    dd($content);
                    // $file=generarPDF();
                    // $file=$content;
                }
                $curso->crearCapacitacion($colaborador, $file);
            }
        });

        return response()->json(null, 201);
    }
}
