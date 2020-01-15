<?php

use Illuminate\Database\Migrations\Migration;

class AddMultipleRegistersInTagsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('tags')->insert([
            [
                'nombre' => 'Relator Interno',
                'descripcion' => '',
                'tipo' => 'Positivo',
                'permisos' => '',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nombre' => 'Monitor Pausa Activa',
                'descripcion' => '',
                'tipo' => 'Positivo',
                'permisos' => '',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nombre' => 'Auditor Interno',
                'descripcion' => '',
                'tipo' => 'Positivo',
                'permisos' => '',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        $nombres = array(
            'Relator Interno',
            'Monitor Pausa Activa',
            'Auditor Interno',
        );

        DB::table('tags')->whereIn('nombre', $nombres)->delete();
    }
}
