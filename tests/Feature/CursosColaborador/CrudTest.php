<?php

namespace Tests\Feature\CursosColaborador;

use App\Curso;
use Tests\TestCase;
use App\Colaborador;
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

    public function testCrearCursoColaboradorMasivo()
    {
        $colaborador = factory(Colaborador::class)->create();
        $segundoColaborador = factory(Colaborador::class)->create();
        $curso = factory(Curso::class)->create();
        $cursoColaborador = factory(CursoColaborador::class)->make();

        Storage::fake('local');

        $url = '/api/cursos/'.$curso->id.'/colaboradores';

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
        // dd($response->decodeResponseJson());
        $response->assertStatus(200);

        $this->assertSoftDeleted('cursos_colaborador', [
            'id' => $colaborador[0]->capacitaciones[0]->id,
        ]);

        // $response = $this->json('GET', '/api/cursos');
        // $response->assertStatus(200)
        //     ->assertJsonCount(4, 'data')
        //     ->assertJson([
        //         'data' => [
        //             '0' => ['id' => $cursos[1]->id],
        //             '1' => ['id' => $cursos[2]->id],
        //             '2' => ['id' => $cursos[3]->id],
        //             '3' => ['id' => $cursos[4]->id],
        //         ],
        //     ]);
    }
}
