<?php

namespace App\Http\Controllers\Periodos;

use App\Area;
use App\Periodo;
use App\ResultadoArea;
use App\DetalleRespuesta;
use App\Http\Controllers\Controller;
use App\Http\Resources\ResultadoAreaResource;

class ShowResultsController extends Controller
{
    public function __invoke($id)
    {
        $periodo = Periodo::findOrFail($id);
        $encuestas = $periodo->encuestas;
        $detallesRespuestas = DetalleRespuesta::whereIn('encuesta_id', $encuestas->pluck('id')->toArray())
                                ->get();

        // eliminar registros anteriores
        $resultadoAreas = $periodo->resultadoAreas;
        ResultadoArea::whereIn('periodo_id', $resultadoAreas->pluck('periodo_id'))->delete();

        $areas = Area::orderBy('tipo_area_id', 'DESC')->get();
        // dd($areas->pluck('id'));
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

            // if ($promedio) {
            //     $sumaTotal = $sumaTotal + $promedio;
            //     $areasConPromedio = $areasConPromedio + 1;
            // }

            $areaResultado = ResultadoArea::make([
                'resultado' => $promedio,
            ]);

            $areaResultado->area()->associate($area->id);
            $areaResultado->periodo()->associate($periodo->id);
            $areaResultado->save();
        }

        // $areaGerenciaGeneral = ResultadoArea::make([
        //     'resultado' => $sumaTotal / $areasConPromedio,
        // ]);

        // $areaGerenciaGeneral->area()->associate(1);
        // $areaGerenciaGeneral->periodo()->associate($periodo->id);
        // $areaGerenciaGeneral->save();

        return ResultadoAreaResource::collection($periodo->resultadoAreas->sortByDesc('tipo_area_id'));
    }
}
