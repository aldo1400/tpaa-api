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
    public function testCrearCursoColaborador()
    {
        $colaborador = factory(Colaborador::class)->create();
        $curso = factory(Curso::class)->create();
        $cursoColaborador = factory(CursoColaborador::class)->make();

        Storage::fake('local');

        $url = '/api/cursos/'.$curso->id.'/colaboradores';

        $image = UploadedFile::fake()->image('curso123.jpg', 1200, 750);
        // $image = UploadedFile::fake()->image('banner1.jpg', 1200, 750);

        $parameters = [
            'diploma' => $image,
            'colaborador_id' => $colaborador->id,
        ];

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $diplomaUrl = 'public/diplomas/'.$curso->id.'_'.$curso->nombre.'.'.$image->extension();

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => CursoColaborador::latest()->first()->id,
            'curso_id' => $curso->id,
            'colaborador_id' => $parameters['colaborador_id'],
            'url_diploma' => $diplomaUrl,
        ]);
    }
}
