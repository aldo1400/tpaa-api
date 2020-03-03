<?php

namespace Tests\Feature\Comentarios;

use App\Cargo;
use App\Movilidad;
use App\Comentario;
use Tests\TestCase;
use App\Colaborador;
use App\TipoMovilidad;
use App\TipoComentario;

class CrudTest extends TestCase
{
    public function testCrearComentario()
    {
        $colaboradorAutor = factory(Colaborador::class)->create();
        $colaboradorReceptor = factory(Colaborador::class)->create();
        $cargoReceptor = factory(Cargo::class)->create();
        $tipoComentario = factory(TipoComentario::class)->create();
        $TipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::NUEVO)->first();

        factory(Movilidad::class)->create([
            'colaborador_id' => $colaboradorReceptor->id,
            'cargo_id' => $cargoReceptor->id,
            'tipo_movilidad_id' => $TipoMovilidad->id,
            'estado' => 1,
            'fecha_inicio' => now()->format('Y-m-d'),
        ]);

        $url = '/api/comentarios';

        $parameters = [
            'texto_libre' => 'Un comentario random',
            'publico' => 1,
            'fecha' => now()->addDays(2)->format('Y-m-d'),
            'estado' => 1,
            'colaborador_id' => $colaboradorReceptor->id,
            'colaborador_autor_id' => $colaboradorAutor->id,
            'tipo_comentario_id' => $tipoComentario->id,
            'positivo' => 1,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('comentarios', [
            'id' => Comentario::latest()->first()->id,
            'texto_libre' => $parameters['texto_libre'],
            'publico' => $parameters['publico'],
            'fecha' => $parameters['fecha'],
            'estado' => $parameters['estado'],
            'colaborador_id' => $parameters['colaborador_id'],
            'colaborador_autor_id' => $parameters['colaborador_autor_id'],
            'tipo_comentario_id' => $parameters['tipo_comentario_id'],
            'positivo' => $parameters['positivo'],
        ]);
    }

    public function testEditarComentario()
    {
        $colaboradorAutor = factory(Colaborador::class)->create();
        $colaboradorReceptor = factory(Colaborador::class)->create();
        $tipoComentario = factory(TipoComentario::class)->create();
        $comentario = factory(Comentario::class)->create([
            'estado' => 1,
            'publico' => 1,
        ]);

        $url = '/api/comentarios/'.$comentario->id;

        $parameters = [
            'texto_libre' => 'Otro comentario random',
            'publico' => 1,
            'fecha' => now()->addDays(2)->format('Y-m-d'),
            'estado' => 1,
            'colaborador_id' => $colaboradorReceptor->id,
            'colaborador_autor_id' => $colaboradorAutor->id,
            'tipo_comentario_id' => $tipoComentario->id,
            'positivo' => 1,
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('comentarios', [
            'id' => $comentario->id,
            'texto_libre' => $parameters['texto_libre'],
            'publico' => $parameters['publico'],
            'fecha' => $parameters['fecha'],
            'estado' => $parameters['estado'],
            'colaborador_id' => $parameters['colaborador_id'],
            'colaborador_autor_id' => $parameters['colaborador_autor_id'],
            'tipo_comentario_id' => $parameters['tipo_comentario_id'],
            'positivo' => $parameters['positivo'],
        ]);

        $this->assertDatabaseMissing('comentarios', [
            'id' => $comentario->id,
            'texto_libre' => $comentario->texto_libre,
            'publico' => $comentario->publico,
            'fecha' => $comentario->fecha,
            'estado' => $comentario->estado,
            'colaborador_id' => $comentario->colaborador_id,
            'colaborador_autor_id' => $comentario->colaborador_autor_id,
            'tipo_comentario_id' => $comentario->tipo_comentario_id,
            'positivo' => $comentario->positivo,
        ]);
    }

    public function testValidarFechaDeComentario()
    {
        $colaboradorAutor = factory(Colaborador::class)->create();
        $colaboradorReceptor = factory(Colaborador::class)->create();
        $cargoReceptor = factory(Cargo::class)->create();
        $tipoComentario = factory(TipoComentario::class)->create();
        $TipoMovilidad = TipoMovilidad::where('tipo', TipoMovilidad::NUEVO)->first();

        factory(Movilidad::class)->create([
            'colaborador_id' => $colaboradorReceptor->id,
            'cargo_id' => $cargoReceptor->id,
            'tipo_movilidad_id' => $TipoMovilidad->id,
            'estado' => 1,
            'fecha_inicio' => now()->format('Y-m-d'),
        ]);

        $url = '/api/comentarios/';

        $parameters = [
            'texto_libre' => 'Otro comentario random',
            'publico' => 1,
            'fecha' => now()->subDays(2)->format('Y-m-d'),
            'estado' => 1,
            'colaborador_id' => $colaboradorReceptor->id,
            'colaborador_autor_id' => $colaboradorAutor->id,
            'tipo_comentario_id' => $tipoComentario->id,
            'positivo' => 1,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(409)
                ->assertSeeText(json_encode('La fecha del comentario es inválida.'));
    }

    public function testObtenerTodosLosComentarios()
    {
        factory(Comentario::class, 10)->create();

        $url = '/api/comentarios';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'texto_libre',
                        'publico',
                        'fecha',
                        'estado',
                        'tipoComentario' => [
                            'id',
                            'tipo',
                        ],
                        'positivo',
                    ],
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testObtenerUnComentario()
    {
        $comentarios = factory(Comentario::class, 10)
                        ->create();

        $url = '/api/comentarios/'.$comentarios[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'id' => $comentarios[1]->id,
                        'texto_libre' => $comentarios[1]->texto_libre,
                        'publico' => $comentarios[1]->publico,
                        'fecha' => $comentarios[1]->fecha->format('Y-m-d'),
                        'estado' => $comentarios[1]->estado,
                        'tipoComentario' => $comentarios[1]->tipoComentario->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                        'positivo' => $comentarios[1]->positivo,
                    ],
                ]);
    }
}
