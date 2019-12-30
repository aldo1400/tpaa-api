<?php

namespace Tests\Feature\CursosColaborador;

use App\Curso;
use Tests\TestCase;
use App\Colaborador;
use App\CursoColaborador;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase
{
    public function testCrearCursoColaborador(){
        $colaborador=factory(Colaborador::class)->create();
        $curso=factory(Curso::class)->create();
        $cursoColaborador=factory(CursoColaborador::class)->make();

        Storage::fake('local');
        $url='/api/cursos-colaborador';

        $image = UploadedFile::fake()->image('banner1.jpg', 1200, 750);

        $parameters=[
            'fecha'=>$cursoColaborador->fecha->format('Y-m-d'),
            'diploma'=>$image,
            'estado'=>1,
            'curso_id'=>$curso->id,
            'colaborador_id'=>$colaborador->id,
            'tipo_archivo'=>'aldo'
        ];

        $response = $this->json('POST', $url, $parameters);
// dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $this->assertDatabaseHas('cursos_colaborador', [
            'id' => CursoColaborador::latest()->first()->id,
            'fecha' => $parameters['fecha'],
            // 'diploma' => $parameters['tipo'],
            'estado' => $parameters['estado'],
            'curso_id'=>$parameters['curso_id'],
            'colaborador_id'=>$parameters['colaborador_id']
        ]);
    }
}
