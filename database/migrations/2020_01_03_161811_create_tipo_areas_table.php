<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoAreasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tipo_areas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_nombre');
            $table->integer('nivel');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });

        DB::table('tipo_areas')->insert([
            [
                'tipo_nombre' => 'Gerencia General',
                'nivel' => 0,
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo_nombre' => 'Gerencia',
                'nivel' => 1,
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo_nombre' => 'Subgerencia',
                'nivel' => 2,
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo_nombre' => 'Area',
                'nivel' => 3,
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo_nombre' => 'Subárea',
                'nivel' => 4,
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
        Schema::dropIfExists('tipo_areas');
    }
}
