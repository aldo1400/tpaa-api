<?php

namespace Tests\Feature\NivelesEducacion;

use Tests\TestCase;
use App\NivelEducacion;

class GetTest extends TestCase
{
    public function testObtenerNivelesEducacion()
    {
        factory(NivelEducacion::class, 10)
                    ->create();

        $url = '/api/niveles-educacion';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nivel_tipo',
                        'estado',
                    ],
                ],
            ]);
    }
}
