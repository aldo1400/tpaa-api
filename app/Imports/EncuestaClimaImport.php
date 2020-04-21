<?php

namespace App\Imports;

use App\Encuesta;
use App\Pregunta;
use App\Respuesta;
use App\Colaborador;
use App\DetalleRespuesta;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class EncuestaClimaImport implements ToCollection, WithValidation, WithHeadingRow
{
    use Importable;
    protected $periodo;
    public $data;

    public function __construct($periodo)
    {
        $this->periodo = $periodo;
    }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $this->data = $rows;

        foreach ($rows as $row) {
            $keys = $row->keys();

            if ($keys->count() != 102) {
                throw ValidationException::withMessages(['message' => 'La cantidad de columnas es menor a la esperada.']);
            }

            if ($keys[1] != 'Encuesta_Facil_ID') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna encuesta fácil id']);
            }

            if ($keys[2] != 'Rut Evaluador') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna rut evaluador']);
            }

            if ($keys[3] != 'Rut  a Evaluar') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna tipo']);
            }

            $customMessages = [
                'required' => 'El campo :attribute es obligatorio : '.$row['Rut Evaluador'],
                'exists' => 'El campo :attribute es inválido : '.$row['Rut Evaluador'],
            ];

            Validator::make($row->toArray(), $this->rules2($row), $customMessages)->validate();

            $encuesta = Encuesta::where('encuesta_facil_id', $row['Encuesta_Facil_ID'])
                        ->first();

            $arrayIdEncuesta = $this->periodo
                                ->encuestas
                                ->pluck('id')
                                ->toArray();

            if (!in_array($encuesta->id, $arrayIdEncuesta)) {
                throw ValidationException::withMessages(['message' => 'Encuesta fácil id no está relacionada con el periodo.']);
            }

            $colaborador = Colaborador::where('rut', $row['Rut Evaluador'])
                            ->first();

            $cargo = $colaborador->cargoActual();

            $areas = $cargo->area->obtenerAreasRelacionadas();

            $detalleRespuesta = DetalleRespuesta::make([
                'evaluador_id' => $colaborador->id,
                'cargo_evaluador_id' => $cargo->id,
                'gerencia_evaluador_id',
                'subgerencia_evaluador_id',
                'area_evaluador_id',
                'subarea_evaluador_id',
                'evaluado_id',
                'cargo_evaluado_id',
                'gerencia_evaluado_id',
                'subgerencia_evaluado_id',
                'area_evaluado_id',
                'subarea_evaluado_id',
                'cargo_polifuncionalidad_id',
                'horas_turno_polifuncionalidad',
                'fecha' => now()->format('Y-m-d'),
                'encuesta_id' => $encuesta->id,
                'cargo_id',
                'area_id',
                'tipo_area_id',
            ]);

            foreach ($areas as $area) {
                if ($area->tipoArea->tipo_nombre == 'Gerencia') {
                    $detalleRespuesta->gerencia_evaluador_id = $area->id;
                }

                if ($area->tipoArea->tipo_nombre == 'Subgerencia') {
                    $detalleRespuesta->subgerencia_evaluador_id = $area->id;
                }

                if ($area->tipoArea->tipo_nombre == 'Area') {
                    $detalleRespuesta->area_evaluador_id = $area->id;
                }

                if ($area->tipoArea->tipo_nombre == 'Subárea') {
                    $detalleRespuesta->subarea_evaluador_id = $area->id;
                }
            }

            $evaluado = Colaborador::where('rut', $row['Rut  a Evaluar'])
                        ->first();

            $cargo = $evaluado->cargoActual();

            $detalleRespuesta->evaluado_id = $evaluado->id;
            $detalleRespuesta->cargo_evaluado_id = $cargo->id;

            $areas = $cargo->area->obtenerAreasRelacionadas();
            $areas->push($cargo->area);

            foreach ($areas as $area) {
                if ($area->tipoArea->tipo_nombre == 'Gerencia') {
                    $detalleRespuesta->gerencia_evaluado_id = $area->id;
                }

                if ($area->tipoArea->tipo_nombre == 'Subgerencia') {
                    $detalleRespuesta->subgerencia_evaluado_id = $area->id;
                }

                if ($area->tipoArea->tipo_nombre == 'Area') {
                    $detalleRespuesta->area_evaluado_id = $area->id;
                }

                if ($area->tipoArea->tipo_nombre == 'Subárea') {
                    $detalleRespuesta->subarea_evaluado_id = $area->id;
                }
            }

            $detalleRespuesta->save();

            for ($i = 4; $i < $keys->count(); ++$i) {
                $pregunta = Pregunta::where('pregunta', $keys[$i])
                            ->first();

                if (!$pregunta) {
                    throw ValidationException::withMessages(['pregunta' => 'No se encuentra la pregunta.']);
                }

                $valor = $row[$keys[$i]];

                $respuesta = Respuesta::make([
                    'resultado' => $valor,
                    'valor_respuesta' => $pregunta->tipo == 'alternativas' ? $this->obtenerValorRespuesta($pregunta, $valor) : null,
                    'detalle_respuesta_id' => $detalleRespuesta->id,
                    'pregunta_id' => $pregunta->id,
                ]);

                $respuesta->save();
            }

            // dd($detalleRespuesta);
        }
    }

    public function obtenerValorRespuesta($pregunta, $valor)
    {
        // dd('aqui');
        $encuestaPlantilla = $pregunta->encuestaPlantilla;
        if ($encuestaPlantilla->tipo_puntaje == 1) {
            // tipo puntaje 1

            switch ($valor) {
                case 'Totalmente de acuerdo':
                    return 1;
                case 'De acuerdo':
                    return 1;
                case  'Ni de acuerdo ni en desacuerdo':
                    return 0;
                case 'En desacuerdo':
                    return -1;
                case'Totalmente en desacuerdo':
                    return -1;
                default:
                    return '';
            }
        } else {
            // tipopuntaje 2

            switch ($valor) {
                case 'Totalmente de acuerdo':
                    return 100;
                case 'De acuerdo':
                    return 75;
                case  'Ni de acuerdo ni en desacuerdo':
                    return 50;
                case 'En desacuerdo':
                    return 25;
                case'Totalmente en desacuerdo':
                    return 0;
                default:
                    return '';
            }
        }
    }

    public function rules(): array
    {
        return [
            '*.rut_evaluador' => [
                            'required',
                            'exists:colaboradores,rut',
                         ],
            '*.nombres_carga' => ['required', 'string', 'max:255'],
        ];
    }

    public function rules2($row): array
    {
        return [
            'Rut Evaluador' => [
                            'required',
                            'exists:colaboradores,rut',
                         ],
            'Encuesta_Facil_ID' => ['required', 'exists:encuestas,encuesta_facil_id'],
            'Rut  a Evaluar' => ['required'],
        ];
    }
}
