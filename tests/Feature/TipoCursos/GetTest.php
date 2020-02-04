<?php

namespace Tests\Feature\TipoCursos;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GetTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testObtenerTipoCursos()
    {
        $url = '/api/tipo-cursos';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'categoria',
                    ],
                ],
            ]);
    }
}
