<?php

namespace Tests\Feature\Cursos;

use App\Curso;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerCursos()
    {
        factory(Curso::class, 10)
                    ->create();

        $url = '/api/cursos';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nombre',
                        'interno',
                    ],
                ],
            ]);
    }
}
