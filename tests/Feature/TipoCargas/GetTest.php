<?php

namespace Tests\Feature\TipoCargas;

use App\TipoCarga;
use Tests\TestCase;

class GetTest extends TestCase
{
    public function testObtenerTipoCargos()
    {
        factory(TipoCarga::class, 10)
                    ->create();

        $url = '/api/tipo-cargas';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'tipo',
                    ],
                ],
            ]);
    }
}
