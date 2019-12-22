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

    /**
     * A basic test example.
     */
    public function testObtenerUnCargo()
    {
        $cursos = factory(Curso::class, 10)
                        ->create();

        $url = '/api/cursos/'.$cursos[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                            'id' => $cursos[1]->id,
                            'nombre' => $cursos[1]->nombre,
                            'interno' => $cursos[1]->interno,
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
