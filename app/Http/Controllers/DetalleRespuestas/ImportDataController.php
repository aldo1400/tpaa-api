<?php

namespace App\Http\Controllers\DetalleRespuestas;

use App\Periodo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClienteInternoImport;
use Illuminate\Validation\ValidationException;

class ImportDataController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $periodo = Periodo::findOrFail($id);

        DB::transaction(function () use ($request,$periodo) {
            $encuestaPlantilla = $periodo->encuestaPlantilla;

            switch ($encuestaPlantilla->id) {
                case 1:

                    if ($request->file->getClientOriginalName() != 'plantilla_cliente_interno.xlsx') {
                        return response()->json(['message' => 'El nombre del archivo es incorrecto.'], 409);
                    }

                    $ruta = $request->file->storeAs(
                        'public/detalle_respuestas',
                        'plantilla_cliente_interno.xlsx'
                    );

                    $encuestas = $periodo->encuestas;

                    // dd($encuestas);
                    foreach ($encuestas as $encuesta) {
                        $detalleRespuestas = $encuesta->detalleRespuestas;
                        foreach ($detalleRespuestas as $detalleRespuesta) {
                            foreach ($detalleRespuesta->respuestas as $respuesta) {
                                $respuesta->delete();
                            }
                            $detalleRespuesta->delete();
                        }
                        $encuesta->delete();
                    }

                    // dd($ruta);
                    // try {
                        // $import->import('import-users.xlsx');
                        $import = new ClienteInternoImport($periodo);
                        Excel::import($import, $ruta);
                        // dd($import->data);
                        // Excel::import(new CargasFamiliaresImport(), 'public/CargasFamiliares.xlsx');
                    // } catch (ValidationException $e) {
                    //     return response()->json(['success' => 'errorList', 'message' => $e->errors()]);
                    // }

                        return response()->json(['data' => $import->data], 200);
                        // return redirect('/')->with('success', 'All good!');
                    break;

                default:
                    // code...
                    break;
            }
        });
    }
}
