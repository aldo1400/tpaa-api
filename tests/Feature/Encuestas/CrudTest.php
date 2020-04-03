<?php

namespace Tests\Feature\Encuestas;

use App\Periodo;
use App\Encuesta;
use Tests\TestCase;
use App\Colaborador;

class CrudTest extends TestCase
{
    public function testObtenerEncuestasPlantillas()
    {
        factory(Encuesta::class, 5)->create();

        $url = '/api/encuestas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'descripcion',
                        'fecha_inicio',
                        'fecha_fin',
                        'encuesta_facil_id',
                        'periodo' => [
                            'id',
                            'nombre',
                            'year',
                            'detalle',
                            'descripcion',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerUnaEncuesta()
    {
        $encuestas = factory(Encuesta::class, 5)->create();

        $url = '/api/encuestas/'.$encuestas[0]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $encuestas[0]->id,
                        'nombre' => $encuestas[0]->nombre,
                        'descripcion' => $encuestas[0]->descripcion,
                        'fecha_inicio' => $encuestas[0]->fecha_inicio->format('Y-m-d'),
                        'fecha_fin' => $encuestas[0]->fecha_fin->format('Y-m-d'),
                        'encuesta_facil_id' => $encuestas[0]->encuesta_facil_id,
                        'periodo' => $encuestas[0]->periodo->only([
                            'id',
                            'nombre',
                            'year',
                            'detalle',
                            'descripcion',
                        ]),
                ],
            ]);
    }

    public function testObtenerTodosLosColaboradoresRelacionadosConUnEncuesta()
    {
        $encuestas = factory(Encuesta::class, 3)->create();

        $encuestasId = $encuestas->pluck('id')->toArray();

        $datos = [];
        $url = 'URL PROVISIONAL';

        foreach ($encuestasId as $encuesta) {
            $datos[$encuesta] = ['estado' => '4', 'url' => $url];
        }

        $colaboradores = factory(Colaborador::class, 3)
                        ->create()
                        ->each(function ($colaborador) use ($datos) {
                            $colaborador->encuestas()
                                        ->sync($datos);
                        });

        $url = '/api/encuestas/'.$encuestas[0]->id.'/colaboradores';

        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJsonCount('3', 'data')
                ->assertJson([
                    'data' => [
                        '0' => [
                            'id' => $colaboradores[0]->id,
                            'rut' => $colaboradores[0]->rut,
                            'primer_nombre' => $colaboradores[0]->primer_nombre,
                            'segundo_nombre' => $colaboradores[0]->segundo_nombre,
                            'apellido_paterno' => $colaboradores[0]->apellido_paterno,
                            'apellido_materno' => $colaboradores[0]->apellido_materno,
                        ],
                        '1' => [
                            'id' => $colaboradores[1]->id,
                            'rut' => $colaboradores[1]->rut,
                            'primer_nombre' => $colaboradores[1]->primer_nombre,
                            'segundo_nombre' => $colaboradores[1]->segundo_nombre,
                            'apellido_paterno' => $colaboradores[1]->apellido_paterno,
                            'apellido_materno' => $colaboradores[1]->apellido_materno,
                        ],
                        '2' => [
                            'id' => $colaboradores[2]->id,
                            'rut' => $colaboradores[2]->rut,
                            'primer_nombre' => $colaboradores[2]->primer_nombre,
                            'segundo_nombre' => $colaboradores[2]->segundo_nombre,
                            'apellido_paterno' => $colaboradores[2]->apellido_paterno,
                            'apellido_materno' => $colaboradores[2]->apellido_materno,
                        ],
                    ],
                ]);
    }

    public function testAsignarColaboradoresDeFormaMasivaAUnaEncuesta()
    {
        $encuestas = factory(Encuesta::class, 5)->create();
        $colaboradores = factory(Colaborador::class, 3)->create();

        $url = '/api/encuestas/'.$encuestas[0]->id.'/colaboradores';

        $parameters = [
            'colaboradores' => $colaboradores->pluck('id')->toArray(),
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[0]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseHas('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[1]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseHas('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[2]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);
    }

    public function testDeasignarColaboradoresDeFormaMasivaAUnaEncuesta()
    {
        $encuestas = factory(Encuesta::class, 5)->create();

        $encuestasId = $encuestas->pluck('id')->toArray();

        $datos = [];
        $url = 'URL PROVISIONAL';

        foreach ($encuestasId as $encuesta) {
            $datos[$encuesta] = ['estado' => '4', 'url' => $url];
        }

        $colaboradores = factory(Colaborador::class, 4)
                        ->create()
                        ->each(function ($colaborador) use ($datos) {
                            $colaborador->encuestas()
                                        ->sync($datos);
                        });

        $url = '/api/encuestas/'.$encuestas[0]->id.'/colaboradores';

        $parameters = [
            'colaboradores' => $colaboradores->pluck('id')->toArray(),
        ];

        $response = $this->json('DELETE', $url, $parameters);

        // dd($response->decodeResponseJson());
        $response->assertStatus(200);

        $this->assertDatabaseMissing('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[0]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseMissing('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[1]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseMissing('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[2]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseMissing('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[3]->id,
            'encuesta_id' => $encuestas[0]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseHas('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[2]->id,
            'encuesta_id' => $encuestas[1]->id,
            'estado' => '4',
        ]);

        $this->assertDatabaseHas('colaborador_encuesta', [
            'colaborador_id' => $colaboradores[2]->id,
            'encuesta_id' => $encuestas[2]->id,
            'estado' => '4',
        ]);
    }

    public function testCrearEncuesta()
    {
        $periodo = factory(Periodo::class)->create();
        $encuesta = factory(Encuesta::class)->make();

        $parameters = [
            'nombre' => $encuesta->nombre,
            'descripcion' => $encuesta->descripcion,
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'fecha_fin' => now()->addDays(5)->format('Y-m-d'),
            'encuesta_facil_id' => '45454',
            'periodo_id' => $periodo->id,
        ];

        $url = '/api/encuestas';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('encuestas', [
            'id' => Encuesta::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'descripcion' => $parameters['descripcion'],
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_fin' => $parameters['fecha_fin'],
            'encuesta_facil_id' => $parameters['encuesta_facil_id'],
            'periodo_id' => $parameters['periodo_id'],
        ]);
    }

    public function testValidarFechaDeInicioYFinAlCrearEncuesta()
    {
        $periodo = factory(Periodo::class)->create();
        $encuesta = factory(Encuesta::class)->make();

        $parameters = [
            'nombre' => $encuesta->nombre,
            'descripcion' => $encuesta->descripcion,
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'fecha_fin' => now()->addDays(1)->format('Y-m-d'),
            'encuesta_facil_id' => '45454',
            'periodo_id' => $periodo->id,
        ];

        $url = '/api/encuestas';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(409)
                    ->assertSeeText(json_encode('Fecha de termino debe ser mayor a la fecha de inicio.'));
    }

    public function testEditarEncuesta()
    {
        $encuesta = factory(Encuesta::class)->create();

        $parameters = [
            'nombre' => 'Un nombre intersante',
            'descripcion' => 'Otra descripcion muy corta la verdad',
            'fecha_inicio' => now()->addDays(2)->format('Y-m-d'),
            'fecha_fin' => now()->addDays(3)->format('Y-m-d'),
            'encuesta_facil_id' => '65454',
        ];

        $url = '/api/encuestas/'.$encuesta->id;

        $response = $this->json('PATCH', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('encuestas', [
            'id' => $encuesta->id,
            'nombre' => $parameters['nombre'],
            'descripcion' => $parameters['descripcion'],
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_fin' => $parameters['fecha_fin'],
            'encuesta_facil_id' => $parameters['encuesta_facil_id'],
            'periodo_id' => $encuesta->periodo_id,
        ]);

        $this->assertDatabaseMissing('encuestas', [
            'id' => $encuesta->id,
            'nombre' => $encuesta->nombre,
            'descripcion' => $encuesta->descripcion,
            'fecha_inicio' => $encuesta->fecha_inicio->format('Y-m-d'),
            'fecha_fin' => $encuesta->fecha_fin->format('Y-m-d'),
            'encuesta_facil_id' => $encuesta->encuesta_facil_id,
            'periodo_id' => $encuesta->periodo_id,
        ]);
    }
}
