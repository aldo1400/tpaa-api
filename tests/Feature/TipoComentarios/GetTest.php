<?php

namespace Tests\Feature\TipoComentarios;

use Tests\TestCase;
use App\TipoComentario;

class GetTest extends TestCase
{
    public function testObtenerTipoComentarios()
    {
        factory(TipoComentario::class, 10)
                    ->create();

        $url = '/api/tipo-comentarios';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
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
