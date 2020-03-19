<?php

namespace App\Http\Controllers\Capacitaciones;

use App\Curso;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CursoColaboradorRequest;

class CreateProcessController extends Controller
{
    public function __invoke(CursoColaboradorRequest $request, $id)
    {
        $curso = Curso::findOrFail($id);

        // validar colaboradores añadidos
        DB::transaction(function () use ($curso,$request) {
            foreach ($request->colaboradores as $colaborador) {
                if ($curso->interno) {
                    $file = $curso->generarPDFCapacitacion($colaborador);
                } else {
                    $file = '';
                }
                $curso->crearCapacitacion($colaborador, $file);
            }
        });

        return response()->json(null, 201);
    }
}
