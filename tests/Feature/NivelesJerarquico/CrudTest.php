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
            ->assertJsonCount(10, 'data')
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
}
