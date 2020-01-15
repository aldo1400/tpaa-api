<?php

use Illuminate\Database\Migrations\Migration;

class AddMultipleRegistersInTipoCargasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('tipo_cargas')->insert([
            [
                'tipo' => 'Cónyuge',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Hijo(a)',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Conviviente',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Nieto(a)',
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
        $tipoCargas = array('Conviviente', 'Nieto(a)', 'Cónyuge', 'Hijo(a)');
        DB::table('tipo_cargas')->whereIn('tipo', $tipoCargas)->delete();
    }
}
