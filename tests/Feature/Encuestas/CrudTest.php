<?php

namespace Tests\Feature\Encuestas;

use App\Encuesta;
use Tests\TestCase;
use App\EncuestaPlantilla;

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
                        'periodo',
                        'descripcion',
                        'fecha_inicio',
                        'fecha_fin',
                        'encuesta_facil_id',
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

    public function testObtenerUnaEncuesta()
    {
        $encuestas = factory(Encuesta::class, 5)->create();

        $url = '/api/encuestas/'.$encuestas[0]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $encuestas[0]->id,
                        'periodo' => $encuestas[0]->periodo,
                        'descripcion' => $encuestas[0]->descripcion,
                        'fecha_inicio' => $encuestas[0]->fecha_inicio->format('Y-m-d'),
                        'fecha_fin' => $encuestas[0]->fecha_fin->format('Y-m-d'),
                        'encuesta_facil_id' => $encuestas[0]->encuesta_facil_id,
                        'encuestaPlantilla' => $encuestas[0]->encuestaPlantilla->only([
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

    public function testCrearEncuesta()
    {
        $encuestaPlantilla = factory(EncuestaPlantilla::class)->create();
        $encuesta = factory(Encuesta::class)->make();

        $parameters = [
            'periodo' => $encuesta->periodo,
            'descripcion' => $encuesta->descripcion,
            'fecha_inicio' => $encuesta->fecha_inicio->format('Y-m-d'),
            'fecha_fin' => $encuesta->fecha_fin->format('Y-m-d'),
            'encuesta_facil_id' => '45454',
            'encuesta_plantilla_id' => $encuestaPlantilla->id,
        ];

        $url = '/api/encuestas';

        $response = $this->json('POST', $url, $parameters);

        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $this->assertDatabaseHas('encuestas', [
            'id' => Encuesta::latest()->first()->id,
            'periodo' => $parameters['periodo'],
            'descripcion' => $parameters['descripcion'],
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_fin' => $parameters['fecha_fin'],
            'encuesta_facil_id' => $parameters['encuesta_facil_id'],
            'encuesta_plantilla_id' => $parameters['encuesta_plantilla_id'],
        ]);
    }
}
