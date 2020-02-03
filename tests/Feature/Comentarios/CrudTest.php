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
}
