<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadoCivilsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('estado_civiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });

        DB::table('estado_civiles')->insert([
            [
                'tipo' => 'Casado (a)',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Soltero (a)',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Divorciado (a)',
                'estado' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'tipo' => 'Unión Civil',
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
        Schema::dropIfExists('estado_civiles');
    }
}
