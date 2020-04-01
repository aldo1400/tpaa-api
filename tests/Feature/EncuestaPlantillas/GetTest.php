<?php

namespace Tests\Feature\EncuestaPlantillas;

use App\Pregunta;
use Tests\TestCase;
use App\EncuestaPlantilla;

class GetTest extends TestCase
{
    public function testObtenerEncuestasPlantillas()
    {
        factory(EncuestaPlantilla::class)->create();

        $url = '/api/encuesta-plantillas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'evaluacion',
                        'descripcion',
                        'tipo_puntaje',
                        'tiene_item',
                        'numero_preguntas',
                    ],
                ],
            ]);
    }

    public function testObtenerPreguntasDeUnaEncuestaPlantilla()
    {
        $encuestaPlantilla = factory(EncuestaPlantilla::class)->create();

        $preguntas = factory(Pregunta::class, 2)->create([
            'encuesta_plantilla_id' => $encuestaPlantilla->id,
        ]);

        $url = '/api/encuesta-plantillas/'.$encuestaPlantilla->id.'/preguntas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    '0' => [
                        'id' => $preguntas[0]->id,
                        'pregunta' => $preguntas[0]->pregunta,
                        'tipo' => $preguntas[0]->tipo,
                        'item' => $preguntas[0]->item,
                        'encuestaPlantilla' => $preguntas[0]->encuestaPlantilla->only([
                                                    'id',
                                                    'nombre',
                                                    'evaluacion',
                                                    'descripcion',
                                                    'tipo_puntaje',
                                                    'tiene_item',
                                                    'numero_preguntas',
                                                ]),
                        ],
                    '1' => [
                        'id' => $preguntas[1]->id,
                        'pregunta' => $preguntas[1]->pregunta,
                        'tipo' => $preguntas[1]->tipo,
                        'item' => $preguntas[1]->item,
                        'encuestaPlantilla' => $preguntas[1]->encuestaPlantilla->only([
                                                    'id',
                                                    'nombre',
                                                    'evaluacion',
                                                    'descripcion',
                                                    'tipo_puntaje',
                                                    'tiene_item',
                                                    'numero_preguntas',
                                                ]),
                        ],
                    ],
            ]);
    }
}
