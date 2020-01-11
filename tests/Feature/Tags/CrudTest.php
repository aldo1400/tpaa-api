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

    public function testEliminarTag()
    {
        $tags = factory(Tag::class, 5)
                    ->create();

        $url = '/api/tags/'.$tags[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('tags', [
            'id' => $tags[0]->id,
        ]);

        $response = $this->json('GET', '/api/tags');
        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJson([
                'data' => [
                    '0' => ['id' => $tags[1]->id],
                    '1' => ['id' => $tags[2]->id],
                    '2' => ['id' => $tags[3]->id],
                    '3' => ['id' => $tags[4]->id],
                ],
            ]);
    }
}
