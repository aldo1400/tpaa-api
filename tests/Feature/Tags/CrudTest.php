<?php

namespace Tests\Feature\Tags;

use App\Tag;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerTipoCargos()
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
}
