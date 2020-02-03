<?php

namespace Tests\Feature\Comentarios;

use App\Comentario;
use Tests\TestCase;
use App\Colaborador;
use App\TipoComentario;

class CrudTest extends TestCase
{
    public function testCrearComentario()
    {
        $colaboradorAutor = factory(Colaborador::class)->create();
        $colaboradorReceptor = factory(Colaborador::class)->create();
        $tipoComentario = factory(TipoComentario::class)->create();

        $url = '/api/comentarios';

        $parameters = [
            'texto_libre' => 'Un comentario random',
            'publico' => 1,
            'fecha' => now()->format('Y-m-d'),
            'estado' => 1,
            'colaborador_id' => $colaboradorReceptor->id,
            'colaborador_autor_id' => $colaboradorAutor->id,
            'tipo_comentario_id' => $tipoComentario->id,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comentarios', [
            'id' => Comentario::latest()->first()->id,
            'texto_libre' => $parameters['texto_libre'],
            'publico' => $parameters['publico'],
            'fecha' => $parameters['fecha'],
            'estado' => $parameters['estado'],
            'colaborador_id' => $parameters['colaborador_id'],
            'colaborador_autor_id' => $parameters['colaborador_autor_id'],
            'tipo_comentario_id' => $parameters['tipo_comentario_id'],
        ]);
    }

    public function testEditarComentario()
    {
        $colaboradorAutor = factory(Colaborador::class)->create();
        $colaboradorReceptor = factory(Colaborador::class)->create();
        $tipoComentario = factory(TipoComentario::class)->create();
        $comentario = factory(Comentario::class)->create([
            'estado' => 1,
            'publico' => 1,
        ]);

        $url = '/api/comentarios/'.$comentario->id;

        $parameters = [
            'texto_libre' => 'Otro comentario random',
            'publico' => 1,
            'fecha' => now()->addDays(2)->format('Y-m-d'),
            'estado' => 1,
            'colaborador_id' => $colaboradorReceptor->id,
            'colaborador_autor_id' => $colaboradorAutor->id,
            'tipo_comentario_id' => $tipoComentario->id,
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comentarios', [
            'id' => $comentario->id,
            'texto_libre' => $parameters['texto_libre'],
            'publico' => $parameters['publico'],
            'fecha' => $parameters['fecha'],
            'estado' => $parameters['estado'],
            'colaborador_id' => $parameters['colaborador_id'],
            'colaborador_autor_id' => $parameters['colaborador_autor_id'],
            'tipo_comentario_id' => $parameters['tipo_comentario_id'],
        ]);

        $this->assertDatabaseMissing('comentarios', [
            'id' => $comentario->id,
            'texto_libre' => $comentario->texto_libre,
            'publico' => $comentario->publico,
            'fecha' => $comentario->fecha,
            'estado' => $comentario->estado,
            'colaborador_id' => $comentario->colaborador_id,
            'colaborador_autor_id' => $comentario->colaborador_autor_id,
            'tipo_comentario_id' => $comentario->tipo_comentario_id,
        ]);
    }

    public function testObtenerTodosLosComentarios()
    {
        factory(Comentario::class, 10)->create();

        $url = '/api/comentarios';
        $response = $this->json('GET', $url);

        // dd($response->decodeResponseJson());
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'texto_libre',
                        'publico',
                        'fecha',
                        'estado',
                        'tipoComentario' => [
                            'id',
                            'tipo',
                        ],
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnComentario()
    {
        $comentarios = factory(Comentario::class, 10)
                        ->create();

        $url = '/api/comentarios/'.$comentarios[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id'=>$comentarios[1]->id,
                        'texto_libre'=>$comentarios[1]->texto_libre,
                        'publico'=>$comentarios[1]->publico,
                        'fecha'=>$comentarios[1]->fecha->format('Y-m-d'),
                        'estado'=>$comentarios[1]->estado,
                        'tipoComentario' => $comentarios[1]->tipoComentario->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                    ],
                ]);
    }
}
