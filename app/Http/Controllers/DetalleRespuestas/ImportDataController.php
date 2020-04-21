<?php

namespace App\Http\Controllers\DetalleRespuestas;

use App\Area;
use App\Periodo;
use App\ResultadoArea;
use App\DetalleRespuesta;
use App\EncuestaPlantilla;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ClienteInternoImport;

class ImportDataController extends Controller
{
    public function __invoke($id, Request $request)
    {
        $periodo = Periodo::findOrFail($id);

        $encuestaPlantilla = $periodo->encuestaPlantilla;

        switch ($encuestaPlantilla->id) {
                case 1:

                    if ($request->file->getClientOriginalName() != EncuestaPlantilla::CLIENTE_INTERNO_FILE_NAME) {
                        return response()->json(['message' => 'El nombre del archivo es incorrecto.'], 409);
                    }

                    $ruta = $request->file->storeAs(
                        'public/detalle_respuestas',
                        EncuestaPlantilla::CLIENTE_INTERNO_FILE_NAME
                    );

                    DB::transaction(function () use ($request,$periodo) {
                        $encuestas = $periodo->encuestas;

                        foreach ($encuestas as $encuesta) {
                            $detalleRespuestas = $encuesta->detalleRespuestas;
                            foreach ($detalleRespuestas as $detalleRespuesta) {
                                foreach ($detalleRespuesta->respuestas as $respuesta) {
                                    $respuesta->delete();
                                }
                                $detalleRespuesta->delete();
                            }
                        }
                    });

                        $import = new ClienteInternoImport($periodo);
                        Excel::import($import, $ruta);

                        $this->calcularResultadosClienteInterno($periodo);

                        return response()->json(['data' => $import->data], 200);
                    break;

                default:
                    // code...
                    break;
            }
    }

    public function calcularResultadosClienteInterno($periodo)
    {
        $encuestas = $periodo->encuestas;
        $detallesRespuestas = DetalleRespuesta::whereIn('encuesta_id', $encuestas->pluck('id')->toArray())
                                ->get();

        $resultadoAreas = $periodo->resultadoAreas;
        ResultadoArea::whereIn('periodo_id', $resultadoAreas->pluck('periodo_id'))->delete();

        $areas = Area::orderBy('tipo_area_id', 'DESC')->get();
        $sumaTotal = 0;
        $areasConPromedio = 0;
        foreach ($areas as $area) {
            $promedio = 0;
            $suma = 0;

            switch ($area->tipoArea->id) {
                case 1:
                    $resultados = $detallesRespuestas;
                    break;
                case 2:
                    $resultados = $detallesRespuestas->where('gerencia_evaluado_id', $area->id);

                    break;
                case 3:
                    $resultados = $detallesRespuestas->where('subgerencia_evaluado_id', $area->id);

                    break;
                case 4:
                    $resultados = $detallesRespuestas->where('area_evaluado_id', $area->id);

                    break;

                case 5:
                    $resultados = $detallesRespuestas->where('subarea_evaluado_id', $area->id);

                    break;
                default:

                    break;
            }

            foreach ($resultados as $resultado) {
                $suma = $suma + $resultado->promedio;
            }

            $promedio = $resultados->count() ? $suma / $resultados->count() : null;

            $areaResultado = ResultadoArea::make([
                'resultado' => $promedio,
            ]);

            $areaResultado->area()->associate($area->id);
            $areaResultado->periodo()->associate($periodo->id);
            $areaResultado->save();
        }
    }
}
