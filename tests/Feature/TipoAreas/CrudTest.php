<?php

namespace Tests\Feature\TipoAreas;

use App\TipoArea;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testObtenerTiposDeArea()
    {
        $url = '/api/tipos-area';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'tipo_nombre',
                        'nivel',
                        'estado',
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnTipoDeArea()
    {
        $tipoArea = TipoArea::first();

        $url = '/api/tipos-area/'.$tipoArea->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                            'id' => $tipoArea->id,
                            'tipo_nombre' => $tipoArea->tipo_nombre,
                            'nivel' => $tipoArea->nivel,
                            'estado' => $tipoArea->estado,
                    ],
                ]);
    }

    public function testCrearTipoDeArea()
    {
        $tipoArea = factory(TipoArea::class)->make();

        $url = '/api/tipos-area';

        $parameters = [
            'tipo_nombre' => $tipoArea->tipo_nombre,
            'estado' => $tipoArea->estado,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('tipo_areas', [
            'id' => TipoArea::latest()->first()->id,
            'tipo_nombre' => $parameters['tipo_nombre'],
            'estado' => $parameters['estado'],
            'nivel' => 5,
        ]);
    }

    public function testEditarTipoArea()
    {
        $tipoArea = TipoArea::first();

        $url = '/api/tipos-area/'.$tipoArea->id;

        $parameters = [
            'tipo_nombre' => 'Nueva Subárea',
            'estado' => 1,
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('tipo_areas', [
            'id' => $tipoArea->id,
            'tipo_nombre' => $parameters['tipo_nombre'],
            'estado' => $parameters['estado'],
            'nivel' => 0,
        ]);

        $this->assertDatabaseMissing('tipo_areas', [
            'id' => $tipoArea->id,
            'tipo_nombre' => $tipoArea->tipo_nombre,
            'estado' => $tipoArea->estado,
            'nivel' => 0,
        ]);
    }
}
