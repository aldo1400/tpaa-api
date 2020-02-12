<?php

namespace Tests\Feature\Notificaciones;

use Tests\TestCase;
use App\Colaborador;

class VencimientoTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testVerificarQueSeCreeNotificacionSiSeVenceLasFechaDeLicenciaByD()
    {
        $colaborador = factory(Colaborador::class)->create([
            'vencimiento_licencia_b' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_licencia_d' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_carnet_portuario' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_credencial_vigilante' => now()->addDays(60)->format('Y-m-d'),
        ]);

        $this->artisan('colaboradores:vencimiento');

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_licencia_b',
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_licencia_d',
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_carnet_portuario',
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_credencial_vigilante',
        ]);
    }

    /**
     * A basic test example.
     */
    public function testVerificarQueSeCreeNotificacionSiSeVenceLasFechaDeCarnetProtuarioYCredencialVigilante()
    {
        $colaborador = factory(Colaborador::class)->create([
            'vencimiento_licencia_b' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_licencia_d' => now()->addDays(60)->format('Y-m-d'),
            'vencimiento_carnet_portuario' => now()->addDays(30)->format('Y-m-d'),
            'vencimiento_credencial_vigilante' => now()->addDays(30)->format('Y-m-d'),
        ]);

        $this->artisan('colaboradores:vencimiento');

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_licencia_b',
        ]);

        $this->assertDatabaseMissing('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_licencia_d',
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_carnet_portuario',
        ]);

        $this->assertDatabaseHas('notificaciones', [
            'colaborador_id' => $colaborador->id,
            'tipo' => 'vencimiento_credencial_vigilante',
        ]);
    }
}
