<?php

namespace App\Http\Controllers\DetalleRespuestas;

use App\Periodo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClienteInternoImport;
use Illuminate\Validation\ValidationException;

class ImportDataController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $nombre = 'ENCUESTA';

        $ruta = $request->file->storeAs(
            'public/detalle_respuestas',
            $nombre.'.'.$request->file->extension()
        );

        // dd($ruta);

        $periodo = Periodo::findOrFail($id);

        $encuestaPlantilla = $periodo->encuestaPlantilla;

        switch ($encuestaPlantilla->id) {
            case 1:

                // try {
                    // $import->import('import-users.xlsx');
                    Excel::import(new ClienteInternoImport($periodo), $ruta);

                    // Excel::import(new CargasFamiliaresImport(), 'public/CargasFamiliares.xlsx');
                // } catch (ValidationException $e) {
                //     return response()->json(['success' => 'errorList', 'message' => $e->errors()]);
                // }

                    return response()->json();
                    // return redirect('/')->with('success', 'All good!');
                break;

            default:
                // code...
                break;
        }
    }
}
