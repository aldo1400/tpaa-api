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
        // dd($response->decodeResponseJson());

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
}
