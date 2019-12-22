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

    public function testCrearCurso()
    {
        $curso = factory(Curso::class)->make();
        $url = '/api/cursos';

        $parameters = [
            'nombre' => $curso->nombre,
            'interno' => $curso->interno,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('cursos', [
            'id' => Curso::latest()->first()->id,
            'nombre' => $parameters['nombre'],
            'interno' => $parameters['interno'],
        ]);
    }
}
