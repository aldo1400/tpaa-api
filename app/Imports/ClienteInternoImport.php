<?php

namespace App\Imports;

use App\Area;
use App\Cargo;
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

class ClienteInternoImport implements ToCollection, WithValidation, WithHeadingRow
{
    use Importable;
    protected $periodo;
    public $data;

    public function __construct($periodo)
    {
        $this->periodo = $periodo;
    }

    // /**
    //  * @param array $row
    //  *
    //  * @return \Illuminate\Database\Eloquent\Model|null
    //  */
    // public function model(array $row)
    // {
    //     return new DetalleRespuesta([
    //     ]);
    // }

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function collection(Collection $rows)
    {
        $this->data = $rows;
        // dd($this->periodo);
        //    dd($rows->toArray());

        // if (!$rows) {
        //     throw ValidationException::withMessages(['message' => 'El excel esta vacio.']);
        // }
        // dd($rows);
        foreach ($rows as $row) {
            $keys = $row->keys();

            if ($keys->count() != 17) {
                throw ValidationException::withMessages(['message' => 'La cantidad de columnas es menor a la esperada.']);
            }

            if ($keys[1] != 'encuesta_facil_id') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna encuesta fácil id']);
            }

            if ($keys[2] != 'rut_evaluador') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna rut evaluador']);
            }

            if ($keys[3] != 'tipo') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna tipo']);
            }

            if ($keys[4] != 'nombre_tipo') {
                throw ValidationException::withMessages(['message' => 'No se encuentra la columna nombre tipo']);
            }

            // dd(Encuesta::all());
            $customMessages = [
                'required' => 'El campo :attribute es obligatorio : '.$row['rut_evaluador'],
                'exists' => 'El campo :attribute es inválido : '.$row['rut_evaluador'],
            ];

            Validator::make($row->toArray(), $this->rules2($row), $customMessages)->validate();

            // dd($row['rut_evaluador']);
            // $validator = Validator::make($row->toArray(), $this->rules());

            // foreach ($validator->errors()->messages() as $messages) {
            //     foreach ($messages as $error) {
            //         // accumulating errors:
            //         // $this->errors[] = $error;
            //         throw new \Maatwebsite\Excel\Validators\ValidationException($validator->errors());
            //     }
            // }

            $encuesta = Encuesta::where('encuesta_facil_id', $row['encuesta_facil_id'])
                        ->first();

            $arrayIdEncuesta = $this->periodo->encuestas->pluck('id')->toArray();
            // dd($arrayIdEncuesta);

            if (!in_array($encuesta->id, $arrayIdEncuesta)) {
                throw ValidationException::withMessages(['message' => 'Encuesta fácil id no está relacionada con el periodo.']);
            }

            // dd('fsdfsd');
            // if ($this->periodo->encuesta->id != $encuesta->id) {
            //     throw ValidationException::withMessages(['message' => 'Encuesta fácil id no esta relacionada con el periodo.']);
            // }

            $colaborador = Colaborador::where('rut', $row['rut_evaluador'])
                            ->first();

            $cargo = $colaborador->cargoActual();

            // dd($cargo);
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
                // if ($area->tipoArea->tipo_nombre = 'Gerencia General') {
                //     $detalleRespuesta->gerecia
                // }

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

            // evaluaddor
            if ($row['tipo'] == 'cargo') {
                $cargo = Cargo::where('nombre', $row['nombre_tipo'])
                        ->first();
                // dd($cargo);
                $detalleRespuesta->cargo_id = $cargo->id;
                $detalleRespuesta->tipo_area_id = $cargo->area->tipoArea->id;

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
            }

            if ($row['tipo'] == 'area') {
                $area = Area::where('nombre', $row['nombre_tipo'])
                        ->first();

                $detalleRespuesta->area_id = $area->id;
                $detalleRespuesta->tipo_area_id = $area->tipoArea->id;

                $areas = $area->obtenerAreasRelacionadas();
                $areas->push($area);
                // dd($areas->count());
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
            }

            // Respuesta::make();
            // dd($row);
            $detalleRespuesta->save();

            //preguntas de forma masiva

            // dd($keys->count());

            for ($i = 5; $i < $keys->count(); ++$i) {
                $pregunta = Pregunta::where('pregunta', $keys[$i])
                            ->first();

                // dd($pregunta);
                if (!$pregunta) {
                    throw ValidationException::withMessages(['pregunta' => 'No se encuentra la pregunta.']);
                }

                $valor = $row[$keys[$i]];

                // dd($valor);
                $respuesta = Respuesta::make([
                    'resultado' => $valor,
                    'valor_respuesta' => $pregunta->tipo == 'alternativas' ? $this->obtenerValorRespuesta($pregunta, $valor) : null,
                    'detalle_respuesta_id' => $detalleRespuesta->id,
                    'pregunta_id' => $pregunta->id,
                ]);

                // dd($respuesta);
                $respuesta->save();
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

    public function rules2($row): array
    {
        if ($row['tipo'] == 'cargo') {
            // dd($row['tipo']);

            return [
                'rut_evaluador' => [
                                'required',
                                'exists:colaboradores,rut',
                             ],
                'encuesta_facil_id' => ['required', 'exists:encuestas,encuesta_facil_id'],
                'tipo' => ['required'],
                'nombre_tipo' => ['required', 'exists:cargos,nombre'],
                // 'encuesta_facil_id' => ['required'],
                // 'nombres_carga' => ['required', 'string', 'max:255'],
                // 'rut_colaborador' => ['required', 'exists:colaboradores,rut'],
                // 'tipo_carga_id' => ['required', 'exists:tipo_cargas,id'],
            ];
        }

        return [
            'rut_evaluador' => [
                            'required',
                            'exists:colaboradores,rut',
                         ],
            'encuesta_facil_id' => ['required', 'exists:encuestas,encuesta_facil_id'],
            'tipo' => ['required'],
            'nombre_tipo' => ['required', 'exists:areas,nombre'],
            // 'encuesta_facil_id' => ['required'],
            // 'nombres_carga' => ['required', 'string', 'max:255'],
            // 'rut_colaborador' => ['required', 'exists:colaboradores,rut'],
            // 'tipo_carga_id' => ['required', 'exists:tipo_cargas,id'],
        ];
    }
}
