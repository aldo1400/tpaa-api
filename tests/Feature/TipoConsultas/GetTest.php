<?php

namespace Tests\Feature\TipoConsultas;

use Tests\TestCase;

class GetTest extends TestCase
{
    public function testObtenerTipoConsultas()
    {
        $url = '/api/tipo-consultas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(4, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'tipo',
                        'estado',
                    ],
                ],
            ]);
    }
}
