<?php

namespace Tests\Feature\Colaboradores;

use App\Tag;
use App\Curso;
use Tests\TestCase;
use App\Colaborador;
use App\EstadoCivil;
use App\Notificacion;
use App\NivelEducacion;
use App\CursoColaborador;
use Freshwork\ChileanBundle\Rut;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CrudTest extends TestCase
{
    public function testObtenerTodosLosColaboradores()
    {
        factory(Colaborador::class, 10)
                    ->create();

        $url = '/api/colaboradores';
        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJsonCount(10, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'usuario',
                        'primer_nombre',
                        'segundo_nombre',
                        'apellido_paterno',
                        'apellido_materno',
                        'sexo',
                        'nacionalidad',
                        'fecha_nacimiento',
                        'edad_colaborador',
                        'email',
                        'domicilio',
                        'licencia_b',
                        'vencimiento_licencia_b',
                        'licencia_d',
                        'vencimiento_licencia_d',
                        'carnet_portuario',
                        'vencimiento_carnet_portuario',
                        'talla_calzado',
                        'talla_chaleco',
                        'talla_polera',
                        'talla_pantalon',
                        'fecha_ingreso',
                        'telefono',
                        'celular',
                        'anexo',
                        'contacto_emergencia_nombre',
                        'contacto_emergencia_telefono',
                        // 'estado',
                        'fecha_inactividad',
                        'nivelEducacion' => [
                            'id',
                            'nivel_tipo',
                            'estado',
                        ],
                        'estadoCivil' => [
                            'id',
                            'tipo',
                            'estado',
                        ],
                        'cargoActual',
                        'movilidadActual',
                        'credencial_vigilante',
                        'vencimiento_credencial_vigilante',
                        'imagen_url',
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosActivosColaboradores()
    {
        factory(Colaborador::class, 3)
                    ->create([
                        'estado' => '1',
                    ]);

        factory(Colaborador::class, 5)
                    ->create([
                        'estado' => '0',
                    ]);

        $url = '/api/colaboradores?estado=true';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(3, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'usuario',
                        'primer_nombre',
                        'segundo_nombre',
                        'apellido_paterno',
                        'apellido_materno',
                        'sexo',
                        'nacionalidad',
                        'fecha_nacimiento',
                        'edad_colaborador',
                        'email',
                        'domicilio',
                        'licencia_b',
                        'vencimiento_licencia_b',
                        'licencia_d',
                        'vencimiento_licencia_d',
                        'carnet_portuario',
                        'vencimiento_carnet_portuario',
                        'talla_calzado',
                        'talla_chaleco',
                        'talla_polera',
                        'talla_pantalon',
                        'fecha_ingreso',
                        'telefono',
                        'celular',
                        'anexo',
                        'contacto_emergencia_nombre',
                        'contacto_emergencia_telefono',
                        // 'estado',
                        'fecha_inactividad',
                        'nivelEducacion' => [
                            'id',
                            'nivel_tipo',
                            'estado',
                        ],
                        'estadoCivil' => [
                            'id',
                            'tipo',
                            'estado',
                        ],
                        'cargoActual',
                        'movilidadActual',
                        'credencial_vigilante',
                        'vencimiento_credencial_vigilante',
                        'imagen_url',
                    ],
                ],
            ]);
    }

    public function testObtenerTodosLosInactivosColaboradores()
    {
        factory(Colaborador::class, 3)
                    ->create([
                        'estado' => '1',
                    ]);

        factory(Colaborador::class, 5)
                    ->create([
                        'estado' => '0',
                    ]);

        $url = '/api/colaboradores?estado=false';
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJsonCount(5, 'data')
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id',
                        'usuario',
                        'primer_nombre',
                        'segundo_nombre',
                        'apellido_paterno',
                        'apellido_materno',
                        'sexo',
                        'nacionalidad',
                        'fecha_nacimiento',
                        'edad_colaborador',
                        'email',
                        'domicilio',
                        'licencia_b',
                        'vencimiento_licencia_b',
                        'licencia_d',
                        'vencimiento_licencia_d',
                        'carnet_portuario',
                        'vencimiento_carnet_portuario',
                        'talla_calzado',
                        'talla_chaleco',
                        'talla_polera',
                        'talla_pantalon',
                        'fecha_ingreso',
                        'telefono',
                        'celular',
                        'anexo',
                        'contacto_emergencia_nombre',
                        'contacto_emergencia_telefono',
                        // 'estado',
                        'fecha_inactividad',
                        'nivelEducacion' => [
                            'id',
                            'nivel_tipo',
                            'estado',
                        ],
                        'estadoCivil' => [
                            'id',
                            'tipo',
                            'estado',
                        ],
                        'cargoActual',
                        'movilidadActual',
                        'credencial_vigilante',
                        'vencimiento_credencial_vigilante',
                        'imagen_url',
                    ],
                ],
            ]);
    }

    public function testObtenerUnColaborador()
    {
        $colaboradores = factory(Colaborador::class, 10)
                        ->create();

        $url = '/api/colaboradores/'.$colaboradores[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $colaboradores[1]->id,
                        'rut' => $colaboradores[1]->rut,
                        'usuario' => $colaboradores[1]->usuario,
                        'primer_nombre' => $colaboradores[1]->primer_nombre,
                        'segundo_nombre' => $colaboradores[1]->segundo_nombre,
                        'apellido_paterno' => $colaboradores[1]->apellido_paterno,
                        'apellido_materno' => $colaboradores[1]->apellido_materno,
                        'sexo' => $colaboradores[1]->sexo,
                        'nacionalidad' => $colaboradores[1]->nacionalidad,
                        'fecha_nacimiento' => $colaboradores[1]->fecha_nacimiento->format('Y-m-d'),
                        'edad_colaborador' => $colaboradores[1]->edad_colaborador,
                        'email' => $colaboradores[1]->email,
                        'domicilio' => $colaboradores[1]->domicilio,
                        'licencia_b' => $colaboradores[1]->licencia_b,
                        'vencimiento_licencia_b' => $colaboradores[1]->vencimiento_licencia_b->format('Y-m-d'),
                        'licencia_d' => $colaboradores[1]->licencia_d,
                        'vencimiento_licencia_d' => $colaboradores[1]->vencimiento_licencia_d->format('Y-m-d'),
                        'carnet_portuario' => $colaboradores[1]->carnet_portuario,
                        'vencimiento_carnet_portuario' => $colaboradores[1]->vencimiento_carnet_portuario->format('Y-m-d'),
                        'talla_calzado' => $colaboradores[1]->talla_calzado,
                        'talla_chaleco' => $colaboradores[1]->talla_chaleco,
                        'talla_polera' => $colaboradores[1]->talla_polera,
                        'talla_pantalon' => $colaboradores[1]->talla_pantalon,
                        'fecha_ingreso' => $colaboradores[1]->fecha_ingreso->format('Y-m-d'),
                        'telefono' => $colaboradores[1]->telefono,
                        'celular' => $colaboradores[1]->celular,
                        'anexo' => $colaboradores[1]->anexo,
                        'contacto_emergencia_nombre' => $colaboradores[1]->contacto_emergencia_nombre,
                        'contacto_emergencia_telefono' => $colaboradores[1]->contacto_emergencia_telefono,
                        // 'estado' => $colaboradores[1]->estado,
                        'fecha_inactividad' => $colaboradores[1]->fecha_inactividad->format('Y-m-d'),
                        'credencial_vigilante' => $colaboradores[1]->credencial_vigilante,
                        'vencimiento_credencial_vigilante' => $colaboradores[1]->vencimiento_credencial_vigilante->format('Y-m-d'),
                        'nivelEducacion' => $colaboradores[1]->nivelEducacion->only([
                            'id',
                            'nivel_tipo',
                            'estado',
                        ]),
                        'estadoCivil' => $colaboradores[1]->estadoCivil->only([
                            'id',
                            'tipo',
                            'estado',
                        ]),
                ],
            ]);
    }

    public function testObtenerUnColaboradorSinEstadoCivil()
    {
        $colaboradores = factory(Colaborador::class, 10)
                        ->create([
                            'nivel_educacion_id' => null,
                            'estado_civil_id' => null,
                        ]);

        $url = '/api/colaboradores/'.$colaboradores[1]->id;
        $response = $this->json('GET', $url);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                        'id' => $colaboradores[1]->id,
                        'rut' => $colaboradores[1]->rut,
                        'usuario' => $colaboradores[1]->usuario,
                        'primer_nombre' => $colaboradores[1]->primer_nombre,
                        'segundo_nombre' => $colaboradores[1]->segundo_nombre,
                        'apellido_paterno' => $colaboradores[1]->apellido_paterno,
                        'apellido_materno' => $colaboradores[1]->apellido_materno,
                        'sexo' => $colaboradores[1]->sexo,
                        'nacionalidad' => $colaboradores[1]->nacionalidad,
                        'fecha_nacimiento' => $colaboradores[1]->fecha_nacimiento->format('Y-m-d'),
                        'edad_colaborador' => $colaboradores[1]->edad_colaborador,
                        'email' => $colaboradores[1]->email,
                        'domicilio' => $colaboradores[1]->domicilio,
                        'licencia_b' => $colaboradores[1]->licencia_b,
                        'vencimiento_licencia_b' => $colaboradores[1]->vencimiento_licencia_b->format('Y-m-d'),
                        'licencia_d' => $colaboradores[1]->licencia_d,
                        'vencimiento_licencia_d' => $colaboradores[1]->vencimiento_licencia_d->format('Y-m-d'),
                        'carnet_portuario' => $colaboradores[1]->carnet_portuario,
                        'vencimiento_carnet_portuario' => $colaboradores[1]->vencimiento_carnet_portuario->format('Y-m-d'),
                        'talla_calzado' => $colaboradores[1]->talla_calzado,
                        'talla_chaleco' => $colaboradores[1]->talla_chaleco,
                        'talla_polera' => $colaboradores[1]->talla_polera,
                        'talla_pantalon' => $colaboradores[1]->talla_pantalon,
                        'fecha_ingreso' => $colaboradores[1]->fecha_ingreso->format('Y-m-d'),
                        'telefono' => $colaboradores[1]->telefono,
                        'celular' => $colaboradores[1]->celular,
                        'anexo' => $colaboradores[1]->anexo,
                        'contacto_emergencia_nombre' => $colaboradores[1]->contacto_emergencia_nombre,
                        'contacto_emergencia_telefono' => $colaboradores[1]->contacto_emergencia_telefono,
                        // 'estado' => $colaboradores[1]->estado,
                        'fecha_inactividad' => $colaboradores[1]->fecha_inactividad->format('Y-m-d'),
                        'credencial_vigilante' => $colaboradores[1]->credencial_vigilante,
                        'vencimiento_credencial_vigilante' => $colaboradores[1]->vencimiento_credencial_vigilante->format('Y-m-d'),
                        'nivelEducacion' => '',
                        'estadoCivil' => '',
                ],
            ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearColaborador()
    {
        $colaborador = factory(Colaborador::class)->make();

        $nivelEducacion = factory(NivelEducacion::class)
                        ->state('activo')
                        ->create();

        $estadoCivil = factory(EstadoCivil::class)
                        ->state('activo')
                        ->create();

        $image = UploadedFile::fake()->image('banner1.jpg', 1200, 750);

        $tags = factory(Tag::class, 3)->create();

        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'primer_nombre' => $colaborador->primer_nombre,
            'segundo_nombre' => $colaborador->segundo_nombre,
            'apellido_materno' => $colaborador->apellido_materno,
            'apellido_paterno' => $colaborador->apellido_paterno,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('Y-m-d'),
            'email' => $colaborador->email,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
            'estado_civil_id' => $estadoCivil->id,
            'nivel_educacion_id' => $nivelEducacion->id,
            'tags' => $tags->pluck('id'),
            'imagen' => $image,
            'fecha_inicio' => now()->format('Y-m-d'),
            'credencial_vigilante' => $colaborador->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaborador->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $imageUrl = 'public/colaboradores/imagenes/'.$colaborador->rut.'.'.$image->clientExtension();
        Storage::disk('local')->assertExists($imageUrl);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => $parameters['segundo_nombre'],
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => $parameters['apellido_materno'],
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => null,
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => $parameters['carnet_portuario'],
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $parameters['estado'],
            'fecha_inactividad' => null,
            'estado_civil_id' => $parameters['estado_civil_id'],
            'nivel_educacion_id' => $parameters['nivel_educacion_id'],
            'credencial_vigilante' => $parameters['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            'imagen_url' => url(Storage::url($imageUrl)),
        ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[0]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[1]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[2]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearColaboradorSinPassword()
    {
        $colaborador = factory(Colaborador::class)->make();

        $nivelEducacion = factory(NivelEducacion::class)
                        ->state('activo')
                        ->create();

        $estadoCivil = factory(EstadoCivil::class)
                        ->state('activo')
                        ->create();

        $image = UploadedFile::fake()->image('banner1.jpg', 1200, 750);

        $tags = factory(Tag::class, 3)->create();

        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => '',
            'primer_nombre' => $colaborador->primer_nombre,
            'segundo_nombre' => $colaborador->segundo_nombre,
            'apellido_materno' => $colaborador->apellido_materno,
            'apellido_paterno' => $colaborador->apellido_paterno,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('Y-m-d'),
            'email' => $colaborador->email,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
            'estado_civil_id' => $estadoCivil->id,
            'nivel_educacion_id' => $nivelEducacion->id,
            'tags' => $tags->pluck('id'),
            'imagen' => $image,
            'fecha_inicio' => now()->format('Y-m-d'),
            'credencial_vigilante' => $colaborador->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaborador->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $imageUrl = 'public/colaboradores/imagenes/'.$colaborador->rut.'.'.$image->clientExtension();
        Storage::disk('local')->assertExists($imageUrl);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => $parameters['segundo_nombre'],
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => $parameters['apellido_materno'],
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => null,
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => $parameters['carnet_portuario'],
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            // 'estado' => $parameters['estado'],
            'fecha_inactividad' => null,
            // 'estado_civil_id' => $parameters['estado_civil_id'],
            // 'nivel_educacion_id' => $parameters['nivel_educacion_id'],
            // 'credencial_vigilante' => $parameters['credencial_vigilante'],
            // 'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            // 'imagen_url' => url(Storage::url($imageUrl)),
            'password' => '',
        ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[0]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[1]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[2]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);
    }

    /**
     * A basic test example.
     */
    public function testCrearColaboradorSinEstadoCivil()
    {
        $colaborador = factory(Colaborador::class)->make();

        $nivelEducacion = factory(NivelEducacion::class)
                        ->state('activo')
                        ->create();

        $estadoCivil = factory(EstadoCivil::class)
                        ->state('activo')
                        ->create();

        $image = UploadedFile::fake()->image('banner1.jpg', 1200, 750);

        $tags = factory(Tag::class, 3)->create();

        $url = '/api/colaboradores';

        $parameters = [
            'rut' => $colaborador->rut,
            'usuario' => $colaborador->usuario,
            'password' => 'aldo123',
            'primer_nombre' => $colaborador->primer_nombre,
            'segundo_nombre' => $colaborador->segundo_nombre,
            'apellido_materno' => $colaborador->apellido_materno,
            'apellido_paterno' => $colaborador->apellido_paterno,
            'sexo' => $colaborador->sexo,
            'nacionalidad' => $colaborador->nacionalidad,
            'fecha_nacimiento' => $colaborador->fecha_nacimiento->format('Y-m-d'),
            'email' => $colaborador->email,
            'domicilio' => $colaborador->domicilio,
            'licencia_b' => $colaborador->licencia_b,
            'vencimiento_licencia_b' => $colaborador->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaborador->licencia_d,
            'vencimiento_licencia_d' => $colaborador->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => $colaborador->carnet_portuario,
            'vencimiento_carnet_portuario' => $colaborador->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => $colaborador->talla_calzado,
            'talla_chaleco' => $colaborador->talla_chaleco,
            'talla_polera' => $colaborador->talla_polera,
            'talla_pantalon' => $colaborador->talla_pantalon,
            'fecha_ingreso' => $colaborador->fecha_ingreso->format('Y-m-d'),
            'telefono' => $colaborador->telefono,
            'celular' => $colaborador->celular,
            'anexo' => $colaborador->anexo,
            'contacto_emergencia_nombre' => $colaborador->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaborador->contacto_emergencia_telefono,
            'estado' => $colaborador->estado,
            'fecha_inactividad' => '',
            'estado_civil_id' => '',
            'nivel_educacion_id' => '',
            'tags' => $tags->pluck('id'),
            'imagen' => $image,
            'fecha_inicio' => now()->format('Y-m-d'),
            'credencial_vigilante' => $colaborador->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaborador->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('POST', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(201);

        $imageUrl = 'public/colaboradores/imagenes/'.$colaborador->rut.'.'.$image->clientExtension();
        Storage::disk('local')->assertExists($imageUrl);

        $this->assertDatabaseHas('colaboradores', [
            'id' => Colaborador::latest()->first()->id,
            'rut' => $parameters['rut'],
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => $parameters['segundo_nombre'],
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => $parameters['apellido_materno'],
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => null,
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => $parameters['carnet_portuario'],
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $parameters['estado'],
            'fecha_inactividad' => null,
            'estado_civil_id' => null,
            'nivel_educacion_id' => null,
            'credencial_vigilante' => $parameters['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            'imagen_url' => url(Storage::url($imageUrl)),
        ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[0]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[1]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $tags[2]->id,
                'colaborador_id' => Colaborador::latest()->first()->id,
            ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarColaboradorSinFotoAFoto()
    {
        $anterioresTags = factory(Tag::class, 2)->create();
        $nuevosTags = factory(Tag::class, 2)->create();
        $estadoCivil = factory(EstadoCivil::class)->create();
        $nivelEducacion = factory(NivelEducacion::class)->create();

        Storage::fake('local');
        $nuevaImagen = UploadedFile::fake()->image('banner2.jpg', 1200, 750);

        $colaboradores = factory(Colaborador::class, 1)
                        ->create([
                            'nivel_educacion_id' => null,
                            'estado_civil_id' => null,
                        ])
                        ->each(function ($colaborador) use ($anterioresTags) {
                            $colaborador->tags()->sync($anterioresTags->pluck('id')->toArray());
                        });

        $url = '/api/colaboradores/'.$colaboradores[0]->id;

        $parameters = [
            'rut' => 'RUT-1234578',
            'usuario' => $colaboradores[0]->usuario,
            'primer_nombre' => 'MIKE',
            'segundo_nombre' => '',
            'apellido_materno' => '',
            'apellido_paterno' => 'SHINODA',
            'sexo' => $colaboradores[0]->sexo,
            'nacionalidad' => 'ESTADOUNIDENSE',
            'fecha_nacimiento' => '1997-05-02',
            'edad' => '22',
            'email' => 'achoque1400@gmail.com',
            'domicilio' => $colaboradores[0]->domicilio,
            'licencia_b' => $colaboradores[0]->licencia_b,
            'vencimiento_licencia_b' => $colaboradores[0]->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaboradores[0]->licencia_d,
            'vencimiento_licencia_d' => $colaboradores[0]->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => '',
            'vencimiento_carnet_portuario' => $colaboradores[0]->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => '41',
            'talla_chaleco' => 'S',
            'talla_polera' => 'S',
            'talla_pantalon' => '30',
            'fecha_ingreso' => $colaboradores[0]->fecha_ingreso->format('Y-m-d'),
            'telefono' => '00000123',
            'celular' => '931245655',
            'anexo' => $colaboradores[0]->anexo,
            'contacto_emergencia_nombre' => $colaboradores[0]->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaboradores[0]->contacto_emergencia_telefono,
            'estado' => 'Renuncia',
            'fecha_inactividad' => '2000-01-01',
            'estado_civil_id' => $estadoCivil->id,
            'nivel_educacion_id' => $nivelEducacion->id,
            'tags' => $nuevosTags->pluck('id'),
            'imagen' => $nuevaImagen,
            'credencial_vigilante' => $colaboradores[0]->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaboradores[0]->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $imageUrl = 'public/colaboradores/imagenes/'.$colaboradores[0]->rut.'.'.$nuevaImagen->clientExtension();

        Storage::disk('local')->assertExists($imageUrl);

        $this->assertDatabaseHas('colaboradores', [
            'id' => $colaboradores[0]->id,
            'rut' => $colaboradores[0]->rut,
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => null,
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => null,
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => $parameters['edad'],
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => null,
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $colaboradores[0]->estado,
            'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
            'estado_civil_id' => $parameters['estado_civil_id'],
            'nivel_educacion_id' => $parameters['nivel_educacion_id'],
            'credencial_vigilante' => $parameters['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            'imagen_url' => url(Storage::url($imageUrl)),
        ]);

        $this->assertDatabaseMissing('colaboradores', [
                'id' => $colaboradores[0]->id,
                'rut' => $colaboradores[0]->rut,
                'usuario' => $colaboradores[0]->usuario,
                'primer_nombre' => $colaboradores[0]->primer_nombre,
                'segundo_nombre' => $colaboradores[0]->segundo_nombre,
                'apellido_paterno' => $colaboradores[0]->apellido_paterno,
                'imagen_url' => null,
                'imagen' => null,
                // 'apellido_materno' => null,
                // 'sexo' => $parameters['sexo'],
                // 'nacionalidad' => $parameters['nacionalidad'],
                // 'fecha_nacimiento' => $parameters['fecha_nacimiento'],
                // 'edad' => $parameters['edad'],
                // 'email' => $parameters['email'],
                // 'domicilio' => $parameters['domicilio'],
                // 'licencia_b' => $parameters['licencia_b'],
                // 'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
                // 'licencia_d' => $parameters['licencia_d'],
                // 'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
                // 'carnet_portuario' => $parameters['carnet_portuario'],
                // 'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
                // 'talla_calzado' => $parameters['talla_calzado'],
                // 'talla_chaleco' => $parameters['talla_chaleco'],
                // 'talla_polera' => $parameters['talla_polera'],
                // 'talla_pantalon' => $parameters['talla_pantalon'],
                // 'fecha_ingreso' => $parameters['fecha_ingreso'],
                // 'telefono' => $parameters['telefono'],
                // 'celular' => $parameters['celular'],
                // 'anexo' => $parameters['anexo'],
                // 'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
                // 'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
                // 'estado' => $colaboradores[0]->estado,
                // 'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
                // 'estado_civil_id' => $parameters['estado_civil_id'],
                // 'nivel_educacion_id' => $parameters['nivel_educacion_id'],
                // 'credencial_vigilante' => $parameters['credencial_vigilante'],
                // 'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
                ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);
    }

    public function testEditarColaboradorConNuevaFechaDeVencimientoLicenciaByD()
    {
        $anterioresTags = factory(Tag::class, 2)->create();
        $nuevosTags = factory(Tag::class, 2)->create();
        $estadoCivil = factory(EstadoCivil::class)->create();
        $nivelEducacion = factory(NivelEducacion::class)->create();

        Storage::fake('local');
        $nuevaImagen = UploadedFile::fake()->image('banner2.jpg', 1200, 750);

        $colaboradores = factory(Colaborador::class, 1)
                        ->create([
                            'nivel_educacion_id' => null,
                            'estado_civil_id' => null,
                            'vencimiento_licencia_d' => now()->addDays(25)->format('Y-m-d'),
                            'vencimiento_licencia_b' => now()->addDays(25)->format('Y-m-d'),
                        ])
                        ->each(function ($colaborador) use ($anterioresTags) {
                            $colaborador->tags()->sync($anterioresTags->pluck('id')->toArray());
                        });

        $notificacion = factory(Notificacion::class)->create([
            'colaborador_id' => $colaboradores[0]->id,
            'tipo' => 'licencia_b',
            'mensaje' => 'licencia_b',
        ]);

        $url = '/api/colaboradores/'.$colaboradores[0]->id;

        $parameters = [
            'rut' => 'RUT-1234578',
            'usuario' => $colaboradores[0]->usuario,
            'primer_nombre' => 'MIKE',
            'segundo_nombre' => '',
            'apellido_materno' => '',
            'apellido_paterno' => 'SHINODA',
            'sexo' => $colaboradores[0]->sexo,
            'nacionalidad' => 'ESTADOUNIDENSE',
            'fecha_nacimiento' => '1997-05-02',
            'edad' => '22',
            'email' => 'achoque1400@gmail.com',
            'domicilio' => $colaboradores[0]->domicilio,
            'licencia_b' => $colaboradores[0]->licencia_b,
            'vencimiento_licencia_b' => now()->addDays(60)->format('Y-m-d'),
            'licencia_d' => $colaboradores[0]->licencia_d,
            'vencimiento_licencia_d' => now()->addDays(60)->format('Y-m-d'),
            'carnet_portuario' => '',
            'vencimiento_carnet_portuario' => $colaboradores[0]->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => '41',
            'talla_chaleco' => 'S',
            'talla_polera' => 'S',
            'talla_pantalon' => '30',
            'fecha_ingreso' => $colaboradores[0]->fecha_ingreso->format('Y-m-d'),
            'telefono' => '00000123',
            'celular' => '931245655',
            'anexo' => $colaboradores[0]->anexo,
            'contacto_emergencia_nombre' => $colaboradores[0]->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaboradores[0]->contacto_emergencia_telefono,
            'estado' => 'Renuncia',
            'fecha_inactividad' => '2000-01-01',
            'estado_civil_id' => $estadoCivil->id,
            'nivel_educacion_id' => $nivelEducacion->id,
            'tags' => $nuevosTags->pluck('id'),
            'imagen' => $nuevaImagen,
            'credencial_vigilante' => $colaboradores[0]->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaboradores[0]->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $imageUrl = 'public/colaboradores/imagenes/'.$colaboradores[0]->rut.'.'.$nuevaImagen->clientExtension();

        Storage::disk('local')->assertExists($imageUrl);

        $this->assertDatabaseHas('colaboradores', [
            'id' => $colaboradores[0]->id,
            'rut' => $colaboradores[0]->rut,
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => null,
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => null,
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => $parameters['edad'],
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => null,
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $colaboradores[0]->estado,
            'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
            'estado_civil_id' => $parameters['estado_civil_id'],
            'nivel_educacion_id' => $parameters['nivel_educacion_id'],
            'credencial_vigilante' => $parameters['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            'imagen_url' => url(Storage::url($imageUrl)),
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'id' => $notificacion->id,
            // 'rut' => $colaboradores[0]->rut,
        ]);

        $this->assertDatabaseMissing('colaboradores', [
                'id' => $colaboradores[0]->id,
                'rut' => $colaboradores[0]->rut,
                'usuario' => $colaboradores[0]->usuario,
                'primer_nombre' => $colaboradores[0]->primer_nombre,
                'segundo_nombre' => $colaboradores[0]->segundo_nombre,
                'apellido_paterno' => $colaboradores[0]->apellido_paterno,
                'imagen_url' => null,
                'imagen' => null,
                // 'apellido_materno' => null,
                // 'sexo' => $parameters['sexo'],
                // 'nacionalidad' => $parameters['nacionalidad'],
                // 'fecha_nacimiento' => $parameters['fecha_nacimiento'],
                // 'edad' => $parameters['edad'],
                // 'email' => $parameters['email'],
                // 'domicilio' => $parameters['domicilio'],
                // 'licencia_b' => $parameters['licencia_b'],
                // 'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
                // 'licencia_d' => $parameters['licencia_d'],
                // 'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
                // 'carnet_portuario' => $parameters['carnet_portuario'],
                // 'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
                // 'talla_calzado' => $parameters['talla_calzado'],
                // 'talla_chaleco' => $parameters['talla_chaleco'],
                // 'talla_polera' => $parameters['talla_polera'],
                // 'talla_pantalon' => $parameters['talla_pantalon'],
                // 'fecha_ingreso' => $parameters['fecha_ingreso'],
                // 'telefono' => $parameters['telefono'],
                // 'celular' => $parameters['celular'],
                // 'anexo' => $parameters['anexo'],
                // 'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
                // 'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
                // 'estado' => $colaboradores[0]->estado,
                // 'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
                // 'estado_civil_id' => $parameters['estado_civil_id'],
                // 'nivel_educacion_id' => $parameters['nivel_educacion_id'],
                // 'credencial_vigilante' => $parameters['credencial_vigilante'],
                // 'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
                ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarColaboradorMenosLaFoto()
    {
        $anterioresTags = factory(Tag::class, 2)->create();
        $nuevosTags = factory(Tag::class, 2)->create();
        $estadoCivil = factory(EstadoCivil::class)->create();
        $nivelEducacion = factory(NivelEducacion::class)->create();

        Storage::fake('local');

        $colaboradores = factory(Colaborador::class, 1)
                        ->create()
                        ->each(function ($colaborador) use ($anterioresTags) {
                            $colaborador->tags()->sync($anterioresTags->pluck('id')->toArray());
                        });

        $url = '/api/colaboradores/'.$colaboradores[0]->id;

        $parameters = [
            'rut' => 'RUT-1234578',
            'usuario' => $colaboradores[0]->usuario,
            'primer_nombre' => 'MIKE',
            'segundo_nombre' => '',
            'apellido_materno' => '',
            'apellido_paterno' => 'SHINODA',
            'sexo' => $colaboradores[0]->sexo,
            'nacionalidad' => 'ESTADOUNIDENSE',
            'fecha_nacimiento' => '1997-05-02',
            'edad' => '22',
            'email' => 'achoque1400@gmail.com',
            'domicilio' => $colaboradores[0]->domicilio,
            'licencia_b' => $colaboradores[0]->licencia_b,
            'vencimiento_licencia_b' => $colaboradores[0]->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaboradores[0]->licencia_d,
            'vencimiento_licencia_d' => $colaboradores[0]->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => '',
            'vencimiento_carnet_portuario' => $colaboradores[0]->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => '41',
            'talla_chaleco' => 'S',
            'talla_polera' => 'S',
            'talla_pantalon' => '30',
            'fecha_ingreso' => $colaboradores[0]->fecha_ingreso->format('Y-m-d'),
            'telefono' => '00000123',
            'celular' => '931245655',
            'anexo' => $colaboradores[0]->anexo,
            'contacto_emergencia_nombre' => $colaboradores[0]->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaboradores[0]->contacto_emergencia_telefono,
            'estado' => 'Renuncia',
            'fecha_inactividad' => '2000-01-01',
            'estado_civil_id' => '',
            'nivel_educacion_id' => '',
            'tags' => $nuevosTags->pluck('id'),
            'imagen' => '',
            'imagen_url' => '',
            'credencial_vigilante' => $colaboradores[0]->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaboradores[0]->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('colaboradores', [
            'id' => $colaboradores[0]->id,
            'rut' => $colaboradores[0]->rut,
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => null,
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => null,
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => $parameters['edad'],
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => null,
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $colaboradores[0]->estado,
            'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
            'estado_civil_id' => null,
            'nivel_educacion_id' => null,
            'credencial_vigilante' => $parameters['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            'imagen_url' => null,
            'imagen' => '',
        ]);

        $this->assertDatabaseMissing('colaboradores', [
                'id' => $colaboradores[0]->id,
                'rut' => $colaboradores[0]->rut,
                'usuario' => $colaboradores[0]->usuario,
                'primer_nombre' => $colaboradores[0]->primer_nombre,
                'segundo_nombre' => $colaboradores[0]->segundo_nombre,
                'apellido_paterno' => $colaboradores[0]->apellido_paterno,
                'imagen_url' => null,
                'imagen' => null,
                // 'apellido_materno' => null,
                // 'sexo' => $parameters['sexo'],
                // 'nacionalidad' => $parameters['nacionalidad'],
                // 'fecha_nacimiento' => $parameters['fecha_nacimiento'],
                // 'edad' => $parameters['edad'],
                // 'email' => $parameters['email'],
                // 'domicilio' => $parameters['domicilio'],
                // 'licencia_b' => $parameters['licencia_b'],
                // 'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
                // 'licencia_d' => $parameters['licencia_d'],
                // 'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
                // 'carnet_portuario' => $parameters['carnet_portuario'],
                // 'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
                // 'talla_calzado' => $parameters['talla_calzado'],
                // 'talla_chaleco' => $parameters['talla_chaleco'],
                // 'talla_polera' => $parameters['talla_polera'],
                // 'talla_pantalon' => $parameters['talla_pantalon'],
                // 'fecha_ingreso' => $parameters['fecha_ingreso'],
                // 'telefono' => $parameters['telefono'],
                // 'celular' => $parameters['celular'],
                // 'anexo' => $parameters['anexo'],
                // 'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
                // 'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
                // 'estado' => $colaboradores[0]->estado,
                // 'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
                // 'estado_civil_id' => $parameters['estado_civil_id'],
                // 'nivel_educacion_id' => $parameters['nivel_educacion_id'],
                // 'credencial_vigilante' => $parameters['credencial_vigilante'],
                // 'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
                ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);
    }

    /**
     * A basic test example.
     */
    public function testEditarColaboradorConFotoASinFoto()
    {
        $anterioresTags = factory(Tag::class, 2)->create();
        $nuevosTags = factory(Tag::class, 2)->create();
        $estadoCivil = factory(EstadoCivil::class)->create();
        $nivelEducacion = factory(NivelEducacion::class)->create();

        Storage::fake('local');

        $fotoColaborador = UploadedFile::fake()->image('banner2.jpg', 1200, 750);

        $colaboradores = factory(Colaborador::class, 1)
                        ->create()
                        ->each(function ($colaborador) use ($anterioresTags) {
                            $colaborador->tags()->sync($anterioresTags->pluck('id')->toArray());
                        });

        $urlFoto = Storage::put('public/colaboradores/imagenes/'.$colaboradores[0]->rut.'.jpg', $fotoColaborador);
        $colaboradores[0]->imagen = $fotoColaborador;
        $colaboradores[0]->imagen_url = url(Storage::url($urlFoto));

        $url = '/api/colaboradores/'.$colaboradores[0]->id;

        $parameters = [
            'rut' => 'RUT-1234578',
            'usuario' => $colaboradores[0]->usuario,
            'primer_nombre' => 'MIKE',
            'segundo_nombre' => '',
            'apellido_materno' => '',
            'apellido_paterno' => 'SHINODA',
            'sexo' => $colaboradores[0]->sexo,
            'nacionalidad' => 'ESTADOUNIDENSE',
            'fecha_nacimiento' => '1997-05-02',
            'edad' => '22',
            'email' => 'achoque1400@gmail.com',
            'domicilio' => $colaboradores[0]->domicilio,
            'licencia_b' => $colaboradores[0]->licencia_b,
            'vencimiento_licencia_b' => $colaboradores[0]->vencimiento_licencia_b->format('Y-m-d'),
            'licencia_d' => $colaboradores[0]->licencia_d,
            'vencimiento_licencia_d' => $colaboradores[0]->vencimiento_licencia_d->format('Y-m-d'),
            'carnet_portuario' => '',
            'vencimiento_carnet_portuario' => $colaboradores[0]->vencimiento_carnet_portuario->format('Y-m-d'),
            'talla_calzado' => '41',
            'talla_chaleco' => 'S',
            'talla_polera' => 'S',
            'talla_pantalon' => '30',
            'fecha_ingreso' => $colaboradores[0]->fecha_ingreso->format('Y-m-d'),
            'telefono' => '00000123',
            'celular' => '931245655',
            'anexo' => $colaboradores[0]->anexo,
            'contacto_emergencia_nombre' => $colaboradores[0]->contacto_emergencia_nombre,
            'contacto_emergencia_telefono' => $colaboradores[0]->contacto_emergencia_telefono,
            'estado' => 'Renuncia',
            'fecha_inactividad' => '2000-01-01',
            'estado_civil_id' => $estadoCivil->id,
            'nivel_educacion_id' => $nivelEducacion->id,
            'tags' => $nuevosTags->pluck('id'),
            'imagen' => '',
            'imagen_url' => '',
            'credencial_vigilante' => $colaboradores[0]->credencial_vigilante,
            'vencimiento_credencial_vigilante' => $colaboradores[0]->vencimiento_credencial_vigilante->format('Y-m-d'),
        ];

        $response = $this->json('PATCH', $url, $parameters);
        $response->assertStatus(200);

        $this->assertDatabaseHas('colaboradores', [
            'id' => $colaboradores[0]->id,
            'rut' => $colaboradores[0]->rut,
            'usuario' => $parameters['usuario'],
            'primer_nombre' => $parameters['primer_nombre'],
            'segundo_nombre' => null,
            'apellido_paterno' => $parameters['apellido_paterno'],
            'apellido_materno' => null,
            'sexo' => $parameters['sexo'],
            'nacionalidad' => $parameters['nacionalidad'],
            'fecha_nacimiento' => $parameters['fecha_nacimiento'],
            'edad' => $parameters['edad'],
            'email' => $parameters['email'],
            'domicilio' => $parameters['domicilio'],
            'licencia_b' => $parameters['licencia_b'],
            'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
            'licencia_d' => $parameters['licencia_d'],
            'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
            'carnet_portuario' => null,
            'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
            'talla_calzado' => $parameters['talla_calzado'],
            'talla_chaleco' => $parameters['talla_chaleco'],
            'talla_polera' => $parameters['talla_polera'],
            'talla_pantalon' => $parameters['talla_pantalon'],
            'fecha_ingreso' => $parameters['fecha_ingreso'],
            'telefono' => $parameters['telefono'],
            'celular' => $parameters['celular'],
            'anexo' => $parameters['anexo'],
            'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
            'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
            'estado' => $colaboradores[0]->estado,
            'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
            'estado_civil_id' => $parameters['estado_civil_id'],
            'nivel_educacion_id' => $parameters['nivel_educacion_id'],
            'credencial_vigilante' => $parameters['credencial_vigilante'],
            'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
            'imagen_url' => null,
            'imagen' => '',
        ]);

        $this->assertDatabaseMissing('colaboradores', [
                'id' => $colaboradores[0]->id,
                'rut' => $colaboradores[0]->rut,
                'usuario' => $colaboradores[0]->usuario,
                'primer_nombre' => $colaboradores[0]->primer_nombre,
                'segundo_nombre' => $colaboradores[0]->segundo_nombre,
                'apellido_paterno' => $colaboradores[0]->apellido_paterno,
                'imagen_url' => $colaboradores[0]->imagen_url,
                'imagen' => $colaboradores[0]->imagen,
                // 'apellido_materno' => null,
                // 'sexo' => $parameters['sexo'],
                // 'nacionalidad' => $parameters['nacionalidad'],
                // 'fecha_nacimiento' => $parameters['fecha_nacimiento'],
                // 'edad' => $parameters['edad'],
                // 'email' => $parameters['email'],
                // 'domicilio' => $parameters['domicilio'],
                // 'licencia_b' => $parameters['licencia_b'],
                // 'vencimiento_licencia_b' => $parameters['vencimiento_licencia_b'],
                // 'licencia_d' => $parameters['licencia_d'],
                // 'vencimiento_licencia_d' => $parameters['vencimiento_licencia_d'],
                // 'carnet_portuario' => $parameters['carnet_portuario'],
                // 'vencimiento_carnet_portuario' => $parameters['vencimiento_carnet_portuario'],
                // 'talla_calzado' => $parameters['talla_calzado'],
                // 'talla_chaleco' => $parameters['talla_chaleco'],
                // 'talla_polera' => $parameters['talla_polera'],
                // 'talla_pantalon' => $parameters['talla_pantalon'],
                // 'fecha_ingreso' => $parameters['fecha_ingreso'],
                // 'telefono' => $parameters['telefono'],
                // 'celular' => $parameters['celular'],
                // 'anexo' => $parameters['anexo'],
                // 'contacto_emergencia_nombre' => $parameters['contacto_emergencia_nombre'],
                // 'contacto_emergencia_telefono' => $parameters['contacto_emergencia_telefono'],
                // 'estado' => $colaboradores[0]->estado,
                // 'fecha_inactividad' => $colaboradores[0]->fecha_inactividad,
                // 'estado_civil_id' => $parameters['estado_civil_id'],
                // 'nivel_educacion_id' => $parameters['nivel_educacion_id'],
                // 'credencial_vigilante' => $parameters['credencial_vigilante'],
                // 'vencimiento_credencial_vigilante' => $parameters['vencimiento_credencial_vigilante'],
                ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseHas('colaborador_tag', [
                'tag_id' => $nuevosTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[0]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);

        $this->assertDatabaseMissing('colaborador_tag', [
                'tag_id' => $anterioresTags[1]->id,
                'colaborador_id' => $colaboradores[0]->id,
            ]);
    }

    public function testValidarRUT()
    {
        $rut = '12345679';

        $url = '/api/colaboradores/validacion-rut';

        $parameters = [
            'rut' => $rut,
        ];

        $response = $this->json('GET', $url, $parameters);
        $response->assertStatus(409)
                    ->assertSeeText(json_encode('Error: Rut inválido.'));
    }

    public function testObtenerMisTagsPositivos()
    {
        $colaborador = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) {
                        $colaborador->tags()->saveMany(factory(Tag::class, 4)
                                    ->state('activo')
                                    ->make([
                                        'tipo' => Tag::POSITIVO,
                                    ]));
                    });

        $url = '/api/colaboradores/'.$colaborador[0]->id.'/tags?positivo=true';

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id' => $colaborador[0]->tags[0]->id,
                        'nombre' => $colaborador[0]->tags[0]->nombre,
                        'descripcion' => $colaborador[0]->tags[0]->descripcion,
                        'permisos' => $colaborador[0]->tags[0]->permisos,
                        'estado' => $colaborador[0]->tags[0]->estado,
                        'tipo' => $colaborador[0]->tags[0]->tipo,
                    ],
                    1 => [
                        'id' => $colaborador[0]->tags[1]->id,
                        'nombre' => $colaborador[0]->tags[1]->nombre,
                        'descripcion' => $colaborador[0]->tags[1]->descripcion,
                        'permisos' => $colaborador[0]->tags[1]->permisos,
                        'estado' => $colaborador[0]->tags[1]->estado,
                        'tipo' => $colaborador[0]->tags[1]->tipo,
                    ],
                    2 => [
                        'id' => $colaborador[0]->tags[2]->id,
                        'nombre' => $colaborador[0]->tags[2]->nombre,
                        'descripcion' => $colaborador[0]->tags[2]->descripcion,
                        'permisos' => $colaborador[0]->tags[2]->permisos,
                        'estado' => $colaborador[0]->tags[2]->estado,
                        'tipo' => $colaborador[0]->tags[2]->tipo,
                    ],
                    3 => [
                        'id' => $colaborador[0]->tags[3]->id,
                        'nombre' => $colaborador[0]->tags[3]->nombre,
                        'descripcion' => $colaborador[0]->tags[3]->descripcion,
                        'permisos' => $colaborador[0]->tags[3]->permisos,
                        'estado' => $colaborador[0]->tags[3]->estado,
                        'tipo' => $colaborador[0]->tags[3]->tipo,
                    ],
                ],
        ]);
    }

    public function testObtenerTodosLosTagsDeUnColaborador()
    {
        $colaborador = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) {
                        $colaborador->tags()->saveMany(factory(Tag::class, 4)
                                    ->make([
                                        'tipo' => Tag::POSITIVO,
                                    ]));
                    });

        $url = '/api/colaboradores/'.$colaborador[0]->id.'/tags';

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id' => $colaborador[0]->tags[0]->id,
                        'nombre' => $colaborador[0]->tags[0]->nombre,
                        'descripcion' => $colaborador[0]->tags[0]->descripcion,
                        'permisos' => $colaborador[0]->tags[0]->permisos,
                        'estado' => $colaborador[0]->tags[0]->estado,
                        'tipo' => $colaborador[0]->tags[0]->tipo,
                    ],
                    1 => [
                        'id' => $colaborador[0]->tags[1]->id,
                        'nombre' => $colaborador[0]->tags[1]->nombre,
                        'descripcion' => $colaborador[0]->tags[1]->descripcion,
                        'permisos' => $colaborador[0]->tags[1]->permisos,
                        'estado' => $colaborador[0]->tags[1]->estado,
                        'tipo' => $colaborador[0]->tags[1]->tipo,
                    ],
                    2 => [
                        'id' => $colaborador[0]->tags[2]->id,
                        'nombre' => $colaborador[0]->tags[2]->nombre,
                        'descripcion' => $colaborador[0]->tags[2]->descripcion,
                        'permisos' => $colaborador[0]->tags[2]->permisos,
                        'estado' => $colaborador[0]->tags[2]->estado,
                        'tipo' => $colaborador[0]->tags[2]->tipo,
                    ],
                    3 => [
                        'id' => $colaborador[0]->tags[3]->id,
                        'nombre' => $colaborador[0]->tags[3]->nombre,
                        'descripcion' => $colaborador[0]->tags[3]->descripcion,
                        'permisos' => $colaborador[0]->tags[3]->permisos,
                        'estado' => $colaborador[0]->tags[3]->estado,
                        'tipo' => $colaborador[0]->tags[3]->tipo,
                    ],
                ],
        ]);
    }

    public function testValidarRutSiYaExiste()
    {
        $random_number = rand(1000000, 25000000);
        $rut = new Rut($random_number);

        $colaborador = factory(Colaborador::class)->create([
            'rut' => $rut->fix()->format(),
        ]);

        $url = '/api/colaboradores/validacion-rut';

        $parameters = [
            'rut' => $rut->fix()->format(),
        ];

        $response = $this->json('GET', $url, $parameters);
        // dd($response->decodeResponseJson());
        $response->assertStatus(409)
                ->assertSeeText(json_encode('Error: Rut duplicado.'));
    }

    public function testObtenerTodosLasCapacitacionesDeUnColaborador()
    {
        $curso = factory(Curso::class)->create();
        $colaborador = factory(Colaborador::class, 1)
                    ->create()
                    ->each(function ($colaborador) use ($curso) {
                        $colaborador->capacitaciones()->saveMany(factory(CursoColaborador::class, 4)
                                    ->make([
                                        'colaborador_id' => '',
                                        'curso_id' => $curso->id,
                                    ]));
                    });

        // dd($colaborador[0]->capacitaciones()->count());
        $url = '/api/colaboradores/'.$colaborador[0]->id.'/capacitaciones';

        $response = $this->json('GET', $url);
        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    0 => [
                        'id' => $colaborador[0]->capacitaciones[0]->id,
                        'curso_id' => $colaborador[0]->capacitaciones[0]->curso_id,
                        'colaborador_id' => $colaborador[0]->capacitaciones[0]->colaborador_id,
                    ],
                    1 => [
                        'id' => $colaborador[0]->capacitaciones[1]->id,
                        'curso_id' => $colaborador[0]->capacitaciones[1]->curso_id,
                        'colaborador_id' => $colaborador[0]->capacitaciones[1]->colaborador_id,
                    ],
                    2 => [
                        'id' => $colaborador[0]->capacitaciones[2]->id,
                        'curso_id' => $colaborador[0]->capacitaciones[2]->curso_id,
                        'colaborador_id' => $colaborador[0]->capacitaciones[2]->colaborador_id,
                    ],
                    3 => [
                        'id' => $colaborador[0]->capacitaciones[3]->id,
                        'curso_id' => $colaborador[0]->capacitaciones[3]->curso_id,
                        'colaborador_id' => $colaborador[0]->capacitaciones[3]->colaborador_id,
                    ],
                ],
        ]);
    }
}
