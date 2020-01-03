<?php

namespace Tests\Feature\NivelesJerarquico;

use Tests\TestCase;
use App\NivelJerarquico;

class CrudTest extends TestCase
{
    public function testObtenerNivelesJerarquicos()
    {
        factory(NivelJerarquico::class, 10)
                    ->create();

        $url = '/api/niveles-jerarquico';

        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(16, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'nivel_nombre',
                        'estado',
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnNivelJerarquico()
    {
        $nivelesJerarquico = factory(NivelJerarquico::class, 10)
                        ->create();

        $url = '/api/niveles-jerarquico/'.$nivelesJerarquico[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                            'id' => $nivelesJerarquico[1]->id,
                            'nivel_nombre' => $nivelesJerarquico[1]->nivel_nombre,
                            'estado' => $nivelesJerarquico[1]->estado,
                    ],
                ]);
    }

    public function testCrearNivelJerarquico()
    {
        $nivelJerarquico = factory(NivelJerarquico::class)->make();
        $url = '/api/niveles-jerarquico';

        $parameters = [
            'nivel_nombre' => $nivelJerarquico->nivel_nombre,
            'estado' => $nivelJerarquico->estado,
        ];

        $response = $this->json('POST', $url, $parameters);
        $response->assertStatus(201);

        $this->assertDatabaseHas('niveles_jerarquico', [
            'id' => NivelJerarquico::latest()->first()->id,
            'nivel_nombre' => $parameters['nivel_nombre'],
            'estado' => $parameters['estado'],
        ]);
    }

    public function testEditarNivelJerarquico()
    {
        $nivelJerarquico = factory(NivelJerarquico::class)->create([
            'estado' => 1,
        ]);

        $url = '/api/niveles-jerarquico/'.$nivelJerarquico->id;

        $parameters = [
            'nivel_nombre' => 'NUEVO NIVEL DE JERARQUIA',
            'estado' => 1,
        ];

        $response = $this->json('PUT', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('niveles_jerarquico', [
            'id' => $nivelJerarquico->id,
            'nivel_nombre' => $parameters['nivel_nombre'],
            'estado' => $parameters['estado'],
        ]);

        $this->assertDatabaseMissing('niveles_jerarquico', [
            'id' => $nivelJerarquico->id,
            'nivel_nombre' => $nivelJerarquico->nivel_nombre,
            'estado' => $nivelJerarquico->estado,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEliminarNivelJerarquico()
    {
        $nivelesJerarquico = factory(NivelJerarquico::class, 5)
                    ->create();

        $url = '/api/niveles-jerarquico/'.$nivelesJerarquico[0]->id;

        $response = $this->json('DELETE', $url);

        $response->assertStatus(200);

        $this->assertSoftDeleted('niveles_jerarquico', [
            'id' => $nivelesJerarquico[0]->id,
        ]);

        $response = $this->json('GET', '/api/niveles-jerarquico');
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJson([
                'data' => [
                    '6' => ['id' => $nivelesJerarquico[1]->id],
                    '7' => ['id' => $nivelesJerarquico[2]->id],
                    '8' => ['id' => $nivelesJerarquico[3]->id],
                    '9' => ['id' => $nivelesJerarquico[4]->id],
                ],
            ]);
    }
}
