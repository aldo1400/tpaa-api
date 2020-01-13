<?php

namespace Tests\Feature\Movilidades;

use App\Cargo;
use App\Movilidad;
use Tests\TestCase;
use App\Colaborador;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CrudTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testCrearMovilidadAUnColaborador()
    {
        $colaborador=factory(Colaborador::class)->create();
        $cargo=factory(Cargo::class)->create();
        
        $primeraMovilidad=factory(Movilidad::class)->create([
            'colaborador_id'=>$colaborador->id,
            'cargo_id'=>$cargo->id,
            'fecha_inicio'=>now()->format('Y-m-d'),
            'fecha_termino'=>null,
        ]);

        // dd($primeraMovilidad->tipo);
        
        $parameters=[
            'fecha_termino'=>now()->addDays(1)->format('Y-m-d'),
            'fecha_inicio'=>now()->addDays(2)->format('Y-m-d'),
            'tipo'=>'MOVILIDAD',
            'observaciones'=>'',
            'estado'=>1,
            'cargo_id'=>$cargo->id,
        ];

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('POST', $url,$parameters);

        $response->assertStatus(201);

        $this->assertDatabaseHas('movilidades', [
            'id' => $primeraMovilidad->id,
            'colaborador_id'=>$colaborador->id,
            'cargo_id' => $cargo->id,
            'estado' => 0,
            'fecha_inicio' => $primeraMovilidad->fecha_inicio,
            'fecha_termino' => $parameters['fecha_termino'],
            'tipo' => Movilidad::NUEVO,
            'observaciones' => null,
        ]);

        $this->assertDatabaseHas('movilidades', [
            'colaborador_id'=>$colaborador->id,
            'cargo_id' => $cargo->id,
            'estado' => 1,
            'fecha_inicio' => $parameters['fecha_inicio'],
            'fecha_termino' => null,
            'tipo' =>$parameters['tipo'],
            'observaciones' => null,
        ]);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testEliminarMovilidadDeUnColaborador()
    {
        $colaborador=factory(Colaborador::class)->create();
        $cargo=factory(Cargo::class)->create();
        
        $movilidades=factory(Movilidad::class,3)->create([
            'colaborador_id'=>$colaborador->id,
            'cargo_id'=>$cargo->id,
            'tipo'=>'MOVILIDAD',
            'estado'=>0
        ]);

        $movilidad=factory(Movilidad::class)->create([
            'colaborador_id'=>$colaborador->id,
            'cargo_id'=>$cargo->id,
            'tipo'=>'MOVILIDAD',
            'estado'=>1
        ]);
        

        $url = '/api/colaboradores/'.$colaborador->id.'/movilidades';

        $response = $this->json('DELETE', $url);
// dd($response->decodeResponseJson());
        $response->assertStatus(200);

        $this->assertSoftDeleted('movilidades', [
            'id' => $movilidad->id,
        ]);

        $this->assertDatabaseHas('movilidades', [
            'id' => $movilidades[2]->id,
            'colaborador_id'=>$colaborador->id,
            'cargo_id' => $cargo->id,
            'estado' => 1,
            'fecha_termino'=>null
        ]);

    }
}
