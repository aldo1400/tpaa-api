<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRegistersToTiposComentarioTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::table('tipos_comentario')->insert([
            [
                'tipo' => 'Amonestación',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Felicitación',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Razón de despido',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Otro',
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

        $tipoComentarios = array('Amonestación', 'Felicitación', 'Razón de despido', 'Otro');
        DB::table('tipos_comentario')->whereIn('tipo', $tipoComentarios)->delete();
    }
}
