<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNivelJerarquicosTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('niveles_jerarquico', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nivel_nombre');
            $table->boolean('estado')->default(1);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('niveles_jerarquico')->insert([
            [
                'nivel_nombre' => 'Estratégico',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_nombre' => 'Estratégico Táctico',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_nombre' => 'Táctico',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_nombre' => 'Táctico Operativo',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_nombre' => 'Operativo Supervisión',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'nivel_nombre' => 'Ejecución',
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
        Schema::dropIfExists('niveles_jerarquico');
    }
}
