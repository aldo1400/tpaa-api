<?php

namespace Tests\Feature\Tags;

use App\Tag;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerTags()
    {
        factory(Tag::class, 10)
                    ->create();

        $url = '/api/tags';

        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'descripcion',
                        'permisos',
                        'estado',
                        'tipo',
                    ],
                ],
            ]);
    }

    public function testCrearTag()
    {
        $tag = factory(Tag::class)->make();
        $url = '/api/tags';

        $parameters = [
            'nombre' => $tag->nombre,
            'descripcion' => $tag->descripcion,
            'permisos' => $tag->permisos,
            'estado' => $tag->estado,
            'tipo' => $tag->tipo,
        ];

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $this->assertDatabaseHas('tags', [
            'id' => Tag::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'descripcion' => $parameters['descripcion'],
            'permisos' => $parameters['permisos'],
            'estado' => $parameters['estado'],
            'tipo' => $parameters['tipo'],
        ]);
    }
}
