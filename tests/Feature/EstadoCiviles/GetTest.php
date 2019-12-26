<?php

namespace Tests\Feature\EstadoCiviles;

use Tests\TestCase;

class GetTest extends TestCase
{
    public function testObtenerEstadoCiviles()
    {
        $url = '/api/estado-civiles';
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
