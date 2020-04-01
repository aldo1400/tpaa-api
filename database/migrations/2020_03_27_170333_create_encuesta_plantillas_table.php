<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestaPlantillasTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('encuesta_plantillas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->string('evaluacion');
            $table->string('descripcion');
            $table->string('tipo_puntaje');
            $table->integer('tiene_item');
            $table->integer('numero_preguntas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('encuesta_plantillas');
    }
}
