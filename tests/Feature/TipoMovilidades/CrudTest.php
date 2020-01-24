<?php

namespace Tests\Feature\TipoMovilidades;

use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerTipoMovilidades()
    {
        $url = '/api/tipo-movilidades';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
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
