<?php

namespace Tests\Feature\Periodos;

use App\Periodo;
use App\Encuesta;
use Tests\TestCase;
use App\EncuestaPlantilla;

class CrudTest extends TestCase
{
    public function testObtenerTodosLosPeriodos()
    {
        factory(Periodo::class, 5)->create();

        $url = '/api/periodos';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'year',
                        'detalle',
                        'descripcion',
                        'encuestaPlantilla' => [
                            'id',
                            'nombre',
                            'evaluacion',
                            'descripcion',
                            'tipo_puntaje',
                            'tiene_item',
                            'numero_preguntas',
                        ],
                    ],
                ],
            ]);
    }

    public function testObtenerUnPeriodo()
    {
        $periodos = factory(Periodo::class, 5)->create();

        $url = '/api/periodos/'.$periodos[0]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $periodos[0]->id,
                        'nombre' => $periodos[0]->nombre,
                        'year' => $periodos[0]->year,
                        'detalle' => $periodos[0]->detalle,
                        'descripcion' => $periodos[0]->descripcion,
                        'encuestaPlantilla' => $periodos[0]->encuestaPlantilla->only([
                                                'id',
                                                'nombre',
                                                'evaluacion',
                                                'descripcion',
                                                'tipo_puntaje',
                                                'tiene_item',
                                                'numero_preguntas',
                        ]),
                ],
            ]);
    }

    public function testObtenerEncuestasDeUnPeriodo()
    {
        $periodos = factory(Periodo::class, 5)
                    ->create()
                    ->each(function ($periodo) {
                        $periodo->encuestas()->saveMany(factory(Encuesta::class, 3)->make());
                    });

        $url = '/api/periodos/'.$periodos[0]->id.'/encuestas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJson([
                'data' => [
                    '0' => [
                        'id' => $periodos[0]->encuestas[0]->id,
                        'nombre' => $periodos[0]->encuestas[0]->nombre,
                        'descripcion' => $periodos[0]->encuestas[0]->descripcion,
                        'fecha_inicio' => $periodos[0]->encuestas[0]->fecha_inicio->format('Y-m-d'),
                        'fecha_fin' => $periodos[0]->encuestas[0]->fecha_fin->format('Y-m-d'),
                        'encuesta_facil_id' => $periodos[0]->encuestas[0]->encuesta_facil_id,
                    ],
                    '1' => [
                        'id' => $periodos[0]->encuestas[1]->id,
                        'nombre' => $periodos[0]->encuestas[1]->nombre,
                        'descripcion' => $periodos[0]->encuestas[1]->descripcion,
                        'fecha_inicio' => $periodos[0]->encuestas[1]->fecha_inicio->format('Y-m-d'),
                        'fecha_fin' => $periodos[0]->encuestas[1]->fecha_fin->format('Y-m-d'),
                        'encuesta_facil_id' => $periodos[0]->encuestas[1]->encuesta_facil_id,
                    ],
                    '2' => [
                        'id' => $periodos[0]->encuestas[2]->id,
                        'nombre' => $periodos[0]->encuestas[2]->nombre,
                        'descripcion' => $periodos[0]->encuestas[2]->descripcion,
                        'fecha_inicio' => $periodos[0]->encuestas[2]->fecha_inicio->format('Y-m-d'),
                        'fecha_fin' => $periodos[0]->encuestas[2]->fecha_fin->format('Y-m-d'),
                        'encuesta_facil_id' => $periodos[0]->encuestas[2]->encuesta_facil_id,
                    ],
                ],
            ]);
    }

    public function testCrearPeriodo()
    {
        $encuestaPlantilla = factory(EncuestaPlantilla::class)->create();
        $periodo = factory(Periodo::class)->make();

        $parameters = [
                'nombre' => $periodo->nombre,
                'year' => $periodo->year,
                'detalle' => $periodo->detalle,
                'descripcion' => $periodo->descripcion,
                'encuesta_plantilla_id' => $encuestaPlantilla->id,
        ];

        $url = '/api/periodos';

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('periodos', [
            'id' => Periodo::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'year' => $parameters['year'],
            'detalle' => $parameters['detalle'],
            'descripcion' => $parameters['descripcion'],
            'encuesta_plantilla_id' => $parameters['encuesta_plantilla_id'],
        ]);
    }

    public function testEditarPeriodo()
    {
        $encuestaPlantilla = factory(EncuestaPlantilla::class)->create();
        $encuestaPlantillaNueva = factory(EncuestaPlantilla::class)->create();

        $periodo = factory(Periodo::class)->create([
            'encuesta_plantilla_id' => $encuestaPlantilla->id,
        ]);

        $parameters = [
                'nombre' => 'Encuesta plantilla #3',
                'year' => 2020,
                'detalle' => 'Semestre II',
                'descripcion' => 'Una muy corta y breve descripcion',
                'encuesta_plantilla_id' => $encuestaPlantillaNueva->id,
        ];

        $url = '/api/periodos/'.$periodo->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('periodos', [
            'id' => $periodo->id,
            'nombre' => $parameters['nombre'],
            'year' => $parameters['year'],
            'detalle' => $parameters['detalle'],
            'descripcion' => $parameters['descripcion'],
            'encuesta_plantilla_id' => $parameters['encuesta_plantilla_id'],
        ]);

        $this->assertDatabaseMissing('periodos', [
            'id' => $periodo->id,
            'nombre' => $periodo->nombre,
            'year' => $periodo->year,
            'detalle' => $periodo->detalle,
            'descripcion' => $periodo->descripcion,
            'encuesta_plantilla_id' => $periodo->encuesta_plantilla_id,
        ]);
    }

    public function testValidarNoSePuedeEditarPeriodoSiHayEncuestasRelacionadas()
    {
        $encuestaPlantilla = factory(EncuestaPlantilla::class)->create();
        $encuestaPlantillaNueva = factory(EncuestaPlantilla::class)->create();

        $periodo = factory(Periodo::class)->create([
            'encuesta_plantilla_id' => $encuestaPlantilla->id,
        ]);

        $encuesta = factory(Encuesta::class)->create([
            'periodo_id' => $periodo->id,
        ]);

        $parameters = [
                'nombre' => 'Encuesta plantilla #3',
                'year' => 2020,
                'detalle' => 'Semestre II',
                'descripcion' => 'Una muy corta y breve descripcion',
                'encuesta_plantilla_id' => $encuestaPlantillaNueva->id,
        ];

        $url = '/api/periodos/'.$periodo->id;

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(409)
            ->assertSeeText(json_encode('El periodo tiene encuestas relacionadas.'));
    }

    public function testEliminarPeriodo()
    {
        $periodos = factory(Periodo::class, 5)->create();

        $url = '/api/periodos/'.$periodos[1]->id;

        $response = $this->json('DELETE', $url);

        // dd($response->decodeResponseJson());
        $response->assertStatus(200);

        // $this->assertSoftDeleted('periodos', [
        //     'id' => $periodos[1]->id,
        // ]);

        $response = $this->json('GET', '/api/periodos');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $periodos[0]->id],
                    '1' => ['id' => $periodos[2]->id],
                    '2' => ['id' => $periodos[3]->id],
                    '3' => ['id' => $periodos[4]->id],
                ],
            ]);
    }

    public function testValidarNoSePuedeEliminarPeriodoSiHayEncuestasRelacionadas()
    {
        $encuestaPlantilla = factory(EncuestaPlantilla::class)->create();
        $encuestaPlantillaNueva = factory(EncuestaPlantilla::class)->create();

        $periodo = factory(Periodo::class)->create([
            'encuesta_plantilla_id' => $encuestaPlantilla->id,
        ]);

        $encuesta = factory(Encuesta::class)->create([
            'periodo_id' => $periodo->id,
        ]);

        $url = '/api/periodos/'.$periodo->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(409)
            ->assertSeeText(json_encode('El periodo tiene encuestas relacionadas.'));
    }
}
