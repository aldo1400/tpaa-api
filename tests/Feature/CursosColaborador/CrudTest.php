<?php

namespace Tests\Feature\CursosColaborador;

use App\Curso;
use Tests\TestCase;
use App\Colaborador;
use App\Helpers\Image;
use App\CursoColaborador;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CrudTest extends TestCase
{
    public function testCrearCursoColaboradorManual()
    {
        $colaborador = factory(Colaborador::class)->create();
        $curso = factory(Curso::class)->create();
        $cursoColaborador = factory(CursoColaborador::class)->make();

        Storage::fake('local');

        $url = '/api/colaboradores/'.$colaborador->id.'/capacitaciones';

        $image = UploadedFile::fake()->image('curso123.jpg', 1200, 750);

        $parameters = [
            'diploma' => $image,
            'curso_id' => $curso->id,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $diplomaUrl = 'public/diplomas/'.$curso->nombre.'_'.$colaborador->rut.'.'.$image->extension();

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => CursoColaborador::latest()->first()->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $colaborador->id,
            'url_diploma' => $diplomaUrl,
        ]);
    }

    public function testCrearCursoColaboradorManualSinFoto()
    {
        $colaborador = factory(Colaborador::class)->create();
        $curso = factory(Curso::class)->create();
        $cursoColaborador = factory(CursoColaborador::class)->make();

        Storage::fake('local');

        $url = '/api/colaboradores/'.$colaborador->id.'/capacitaciones';

        $parameters = [
            'diploma' => '',
            'curso_id' => $curso->id,
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => CursoColaborador::latest()->first()->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $colaborador->id,
            'url_diploma' => null,
            'diploma' => null,
        ]);
    }

    public function testCrearCursoColaboradorMasivoInterno()
    {
        $colaborador = factory(Colaborador::class)->create();
        $segundoColaborador = factory(Colaborador::class)->create();
        $curso = factory(Curso::class)->create([
            'interno' => 1,
        ]);
        $cursoColaborador = factory(CursoColaborador::class)->make();

        Storage::fake('local');

        $url = '/api/cursos/'.$curso->id.'/capacitaciones';

        $image = UploadedFile::fake()->image('curso123.jpg', 1200, 750);

        $parameters = [
            'colaboradores' => [
                $colaborador->id,
                $segundoColaborador->id,
            ],
        ];

        $response = $this->json('POST', $url, $parameters);

        $response->assertStatus(201);

        $diplomaUrlOne = 'public/diplomas/'.$curso->nombre.'_'.$colaborador->rut.'.pdf';
        $diplomaUrlTwo = 'public/diplomas/'.$curso->nombre.'_'.$segundoColaborador->rut.'.pdf';

        $this->assertDatabaseHas('cursos_colaborador', [
            'curso_id' => $curso->id,
            'colaborador_id' => $parameters['colaboradores'][0],
            'url_diploma' => $diplomaUrlOne,
        ]);

        $this->assertDatabaseHas('cursos_colaborador', [
            'curso_id' => $curso->id,
            'colaborador_id' => $parameters['colaboradores'][1],
            'url_diploma' => $diplomaUrlTwo,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarCursoColaboradorSoloCurso()
    {
        $curso = factory(Curso::class)
                    ->create();

        $nuevoCurso = factory(Curso::class)
                    ->create();

        $colaborador = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) use ($curso) {
                        $colaborador->capacitaciones()->saveMany(factory(CursoColaborador::class, 4)
                                    ->make([
                                        'colaborador_id' => '',
                                        'curso_id' => $curso->id,
                                        'diploma' => null,
                                        'url_diploma' => '',
                                    ]));
                    });

        $url = '/api/capacitaciones/'.$colaborador[0]->capacitaciones[0]->id;

        $parameters = [
            'curso_id' => $nuevoCurso->id,
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => $colaborador[0]->capacitaciones[0]->id,
            'curso_id' => $parameters['curso_id'],
            'colaborador_id' => $colaborador[0]->id,
            'url_diploma' => '',
            'diploma' => null,
        ]);

        $this->assertDatabaseMissing('cursos_colaborador', [
            'id' => $colaborador[0]->capacitaciones[0]->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $colaborador[0]->id,
            'url_diploma' => '',
            'diploma' => null,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarCursoColaboradorSinDiplomaAConDiploma()
    {
        $curso = factory(Curso::class)
                    ->create();

        $nuevoCurso = factory(Curso::class)
                    ->create();

        Storage::fake('local');

        $diploma = UploadedFile::fake()->create('diploma.pdf');

        $colaborador = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) use ($curso) {
                        $colaborador->capacitaciones()->saveMany(factory(CursoColaborador::class, 4)
                                    ->make([
                                        'colaborador_id' => '',
                                        'curso_id' => $curso->id,
                                        'diploma' => null,
                                        'url_diploma' => '',
                                    ]));
                    });

        $url = '/api/capacitaciones/'.$colaborador[0]->capacitaciones[0]->id;

        $parameters = [
            'curso_id' => $nuevoCurso->id,
            'diploma' => $diploma,
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $diplomaUrl = 'public/diplomas/'.$curso->nombre.'_'.$colaborador[0]->rut.'.'.$diploma->extension();

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => $colaborador[0]->capacitaciones[0]->id,
            'curso_id' => $parameters['curso_id'],
            'colaborador_id' => $colaborador[0]->id,
            'url_diploma' => $diplomaUrl,
            'diploma' => Image::convertImage($diploma),
        ]);

        $this->assertDatabaseMissing('cursos_colaborador', [
            'id' => $colaborador[0]->capacitaciones[0]->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $colaborador[0]->id,
            'url_diploma' => '',
            'diploma' => null,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarCursoColaboradorConDiplomaASinDiploma()
    {
        $curso = factory(Curso::class)
                    ->create();

        $nuevoCurso = factory(Curso::class)
                    ->create();

        Storage::fake('local');

        $colaborador = factory(Colaborador::class)
                        ->create();

        $diploma = UploadedFile::fake()->create('diploma.pdf');
        $diplomaUrl = 'public/diplomas/'.$curso->nombre.'_'.$colaborador->rut.'.'.$diploma->extension();

        $capacitacion = factory(CursoColaborador::class)
                        ->create([
                            'curso_id' => $curso->id,
                            'diploma' => Image::convertImage($diploma),
                            'url_diploma' => $diplomaUrl,
                            'colaborador_id' => $colaborador->id,
                        ]);

        $url = '/api/capacitaciones/'.$capacitacion->id;

        $parameters = [
            'curso_id' => $nuevoCurso->id,
            'diploma' => '',
            'url_diploma' => '',
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => $capacitacion->id,
            'curso_id' => $parameters['curso_id'],
            'colaborador_id' => $colaborador->id,
            'url_diploma' => null,
            'diploma' => null,
        ]);

        $this->assertDatabaseMissing('cursos_colaborador', [
            'id' => $capacitacion->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $colaborador->id,
            'url_diploma' => $capacitacion->url_diploma,
            'diploma' => $capacitacion->diploma,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarCursoColaboradorConDiplomaAOtroConDiploma()
    {
        $curso = factory(Curso::class)
                    ->create();

        $nuevoCurso = factory(Curso::class)
                    ->create();

        Storage::fake('local');

        $colaborador = factory(Colaborador::class)
                        ->create();

        $diploma = UploadedFile::fake()->create('diploma.pdf');
        $nuevoDiploma = UploadedFile::fake()->create('diploma2.pdf');

        $diplomaUrl = 'public/diplomas/'.$curso->nombre.'_'.$colaborador->rut.'.'.$diploma->extension();

        $capacitacion = factory(CursoColaborador::class)
                        ->create([
                            'curso_id' => $curso->id,
                            'diploma' => Image::convertImage($diploma),
                            'url_diploma' => $diplomaUrl,
                            'colaborador_id' => $colaborador->id,
                        ]);

        $url = '/api/capacitaciones/'.$capacitacion->id;

        $parameters = [
            'curso_id' => $nuevoCurso->id,
            'diploma' => $nuevoDiploma,
            'url_diploma' => $diplomaUrl,
        ];

        $response = $this->json('PUT', $url, $parameters);

        $response->assertStatus(200);

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => $capacitacion->id,
            'curso_id' => $parameters['curso_id'],
            'colaborador_id' => $colaborador->id,
            'url_diploma' => $parameters['url_diploma'],
            'diploma' => Image::convertImage($nuevoDiploma),
        ]);

        $this->assertDatabaseMissing('cursos_colaborador', [
            'id' => $capacitacion->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $colaborador->id,
            'url_diploma' => $capacitacion->url_diploma,
            'diploma' => $capacitacion->diploma,
        ]);
    }

    /**
     * A basic test example.
     */
    public function testEliminarCursoColaborador()
    {
        $curso = factory(Curso::class)
                    ->create();

        $colaborador = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) use ($curso) {
                        $colaborador->capacitaciones()->saveMany(factory(CursoColaborador::class, 4)
                                    ->make([
                                        'colaborador_id' => '',
                                        'curso_id' => $curso->id,
                                    ]));
                    });

        $url = '/api/capacitaciones/'.$colaborador[0]->capacitaciones[0]->id;

        $response = $this->json('DELETE', $url);
        $response->assertStatus(200);

        $this->assertSoftDeleted('cursos_colaborador', [
            'id' => $colaborador[0]->capacitaciones[0]->id,
        ]);
    }

    public function testObtenerCursosDisponiblesCuandoElColaboradorTieneCapacitaciones()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cursos = factory(Curso::class, 10)->create([
            'estado' => 1,
        ]);
        factory(CursoColaborador::class)->create([
            'curso_id' => $cursos[0]->id,
            'colaborador_id' => $colaborador->id,
        ]);

        factory(CursoColaborador::class)->create([
            'curso_id' => $cursos[1]->id,
            'colaborador_id' => $colaborador->id,
        ]);

        $url = '/api/colaboradores/'.$colaborador->id.'/cursos-disponibles';
        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    '0' => [
                        'id' => $cursos[2]->id,
                        'nombre' => $cursos[2]->nombre,
                    ],
                    '1' => [
                        'id' => $cursos[3]->id,
                        'nombre' => $cursos[3]->nombre,
                    ],
                    '2' => [
                        'id' => $cursos[4]->id,
                        'nombre' => $cursos[4]->nombre,
                    ],
                ],
            ]);
    }

    public function testObtenerColaboradoresDisponiblesCuandoElCursoTieneCapacitaciones()
    {
        $colaboradores = factory(Colaborador::class, 10)->create([
            'estado' => '1',
        ]);

        $curso = factory(Curso::class)->create([
            'estado' => 1,
        ]);

        factory(CursoColaborador::class)->create([
            'curso_id' => $curso->id,
            'colaborador_id' => $colaboradores[0]->id,
        ]);

        factory(CursoColaborador::class)->create([
            'curso_id' => $curso->id,
            'colaborador_id' => $colaboradores[1]->id,
        ]);

        $url = '/api/cursos/'.$curso->id.'/colaboradores-disponibles';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    '0' => [
                        'id' => $colaboradores[2]->id,
                        'primer_nombre' => $colaboradores[2]->primer_nombre,
                    ],
                    '1' => [
                        'id' => $colaboradores[3]->id,
                        'primer_nombre' => $colaboradores[3]->primer_nombre,
                    ],
                    '2' => [
                        'id' => $colaboradores[4]->id,
                        'primer_nombre' => $colaboradores[4]->primer_nombre,
                    ],
                ],
            ]);
    }

    public function testObtenerCursosDisponiblesCuandoElColaboradorNoTieneCapacitaciones()
    {
        $colaborador = factory(Colaborador::class)->create();
        $cursos = factory(Curso::class, 10)->create();

        $url = '/api/colaboradores/'.$colaborador->id.'/cursos-disponibles';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [],
            ]);
    }
}
