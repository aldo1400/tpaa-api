<?php

namespace Tests\Feature\TipoAreas;

use App\TipoArea;
use Tests\TestCase;

class CrudTest extends TestCase
{
    public function testCrearTipoArea()
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
}
