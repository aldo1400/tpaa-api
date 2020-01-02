<?php

namespace Tests\Feature\NivelesJerarquico;

use Tests\TestCase;
use App\NivelJerarquico;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
                        'estado'
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

}
